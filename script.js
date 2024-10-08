const labels = ["Abdi", "Chelsea"];
const uploadedImages = new Map(); // To keep track of uploaded images and their confidence scores
let detectedFaces = [];
let sendingData = false;
let videoStream = null;

const video = document.getElementById("video");
const videoContainer = document.querySelector(".video-container");
const videoOverlay = document.getElementById("overlay");
const canvInfo = document.getElementById("canvAttend");
const startButton = document.getElementById("startButton");
const endButton = document.getElementById("endAttendance");
const overlay = document.getElementById("overlay"); // Overlay canvas
let webcamStarted = false;
let modelsLoaded = false;

endButton.setAttribute("disabled", "disabled");

// Load models
Promise.all([
  faceapi.nets.ssdMobilenetv1.loadFromUri("http://localhost/frontend/models"),
  faceapi.nets.faceRecognitionNet.loadFromUri(
    "http://localhost/frontend/models"
  ),
  faceapi.nets.faceLandmark68Net.loadFromUri(
    "http://localhost/frontend/models"
  ),
]).then(() => {
  modelsLoaded = true;
});

startButton.addEventListener("click", async () => {
  videoContainer.style.display = "flex";
  videoOverlay.style.display = "flex";
  startButton.setAttribute("disabled", "disabled");
  endButton.removeAttribute("disabled");
  if (!webcamStarted && modelsLoaded) {
    try {
      const stream = await navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false,
      });
      video.srcObject = stream;
      videoStream = stream;
      webcamStarted = true;
    } catch (error) {
      console.error("Error accessing webcam:", error);
    }
  } else if (webcamStarted && modelsLoaded) {
    const stream = await navigator.mediaDevices.getUserMedia({
      video: true,
      audio: false,
    });
    video.srcObject = stream;
    videoStream = stream;
    webcamStarted = true;
  }
});

async function getLabeledFaceDescriptions() {
  const labeledDescriptors = [];
  for (const label of labels) {
    const descriptions = [];
    const imagePaths = [`./labels/${label}/1.png`, `./labels/${label}/2.png`];
    for (const path of imagePaths) {
      try {
        console.log(`Fetching image: ${path}`);
        const img = await faceapi.fetchImage(path);
        console.log(`Processing image: ${path}`);
        const detections = await faceapi
          .detectSingleFace(img)
          .withFaceLandmarks()
          .withFaceDescriptor();
        if (detections) {
          console.log(`Face descriptor found for: ${path}`);
          descriptions.push(detections.descriptor);
        } else {
          console.log(`No face detected in ${path}`);
        }
      } catch (error) {
        console.error(`Error processing ${path}:`, error);
      }
    }
    if (descriptions.length > 0) {
      console.log(`Creating LabeledFaceDescriptors for label: ${label}`);
      labeledDescriptors.push(
        new faceapi.LabeledFaceDescriptors(label, descriptions)
      );
    } else {
      console.log(`No valid face descriptors for label: ${label}`);
    }
  }
  console.log(`Labeled face descriptors created: ${labeledDescriptors.length}`);
  return labeledDescriptors;
}

video.addEventListener("loadedmetadata", () => {
  video.width = video.videoWidth;
  video.height = video.videoHeight;
  overlay.width = video.width;
  overlay.height = video.height;
});

video.addEventListener("play", async () => {
  try {
    const labeledFaceDescriptors = await getLabeledFaceDescriptions();
    if (labeledFaceDescriptors.length === 0) {
      console.error("No labeled face descriptors found.");
      return;
    }

    const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);
    const displaySize = { width: video.width, height: video.height };
    faceapi.matchDimensions(overlay, displaySize);

    const context = overlay.getContext("2d", { willReadFrequently: true });
    if (!context) {
      console.error("Failed to get canvas context.");
      return;
    }

    setInterval(async () => {
      try {
        const detections = await faceapi
          .detectAllFaces(video)
          .withFaceLandmarks()
          .withFaceDescriptors();

        if (displaySize.width === 0 || displaySize.height === 0) {
          console.error("Invalid display dimensions:", displaySize);
          return;
        }

        const resizedDetections = faceapi.resizeResults(
          detections,
          displaySize
        );

        const tempCanvas = document.createElement("canvas");
        tempCanvas.width = overlay.width;
        tempCanvas.height = overlay.height;
        const tempContext = tempCanvas.getContext("2d", {
          willReadFrequently: true,
        });

        let shouldCapture = false;
        let captureLabel = null;

        for (const detection of resizedDetections) {
          const bestMatch = faceMatcher.findBestMatch(detection.descriptor);
          const matchConfidence = bestMatch.distance;

          if (bestMatch.label !== "unknown" && matchConfidence < 0.6) {
            const box = detection.detection.box;
            const drawBox = new faceapi.draw.DrawBox(box, {
              label: bestMatch.toString(),
            });
            drawBox.draw(tempCanvas);

            if (
              !uploadedImages.has(bestMatch.label) ||
              uploadedImages.get(bestMatch.label) < matchConfidence
            ) {
              shouldCapture = true;
              captureLabel = bestMatch.label; // Set label for capturing
              uploadedImages.set(bestMatch.label, matchConfidence);
            }
          }
        }

        if (shouldCapture) {
          const imageBlob = await captureImage();
          if (imageBlob) {
            await saveImageToServer(imageBlob, captureLabel); // Pass label to saveImageToServer
          } else {
            console.error("Failed to capture image");
          }
        }

        context.clearRect(0, 0, overlay.width, overlay.height);
        context.drawImage(tempCanvas, 0, 0);
      } catch (error) {
        console.error("Error during face detection or matching:", error);
      }
    }, 100);
  } catch (error) {
    console.error("Error initializing face recognition:", error);
  }
});

function stopWebcam() {
  if (videoStream) {
    const tracks = videoStream.getTracks();
    tracks.forEach((track) => track.stop());
    video.srcObject = null;
    videoStream = null;
  }
}

function captureImage() {
  const canvas = document.createElement("canvas");
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const context = canvas.getContext("2d");
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  return new Promise((resolve) => {
    canvas.toBlob((blob) => {
      if (blob) {
        resolve(blob);
      } else {
        console.error("Failed to create blob");
        resolve(null); // Resolve with null if blob creation fails
      }
    }, "image/png");
  });
}

async function saveImageToServer(imageBlob, label) {
  const formData = new FormData();
  if (imageBlob instanceof Blob) {
    formData.append("image", imageBlob, "capturedImg.png");
    formData.append("label", label); // Tambahkan label ke FormData
    console.log("Blob appended to FormData");

    try {
      const response = await fetch("http://localhost/frontend/saveImage.php", {
        method: "POST",
        body: formData,
      });

      if (response.ok) {
        const data = await response.json(); // Misalkan server mengembalikan URL gambar dalam format JSON
        if (data.imageUrl) {
          console.log("Image saved successfully");
          displayImageOnCanvas(data.imageUrl); // Tampilkan gambar di canvas
        }
      } else {
        console.error("Failed to save image");
      }
    } catch (error) {
      console.error("Error saving image:", error);
    }
  } else {
    console.error("The imageBlob is not a valid Blob object.");
  }
}

function displayImageOnCanvas(imageUrl) {
  const canvas = document.getElementById("canvAttend");
  const context = canvas.getContext("2d");

  if (context) {
    const img = new Image();
    img.src = imageUrl;

    img.onload = () => {
      canvas.width = img.width;
      canvas.height = img.height;
      context.drawImage(img, 0, 0);
    };

    img.onerror = () => {
      console.error("Failed to load image:", imageUrl);
    };
  } else {
    console.error("Failed to get canvas context.");
  }
}

document.getElementById("endAttendance").addEventListener("click", function () {
  videoOverlay.style.display = "none";
  startButton.removeAttribute("disabled");
  endButton.setAttribute("disabled", "disabled");
  stopWebcam();
});
