<?php include("./admin/config.php");
// Fungsi untuk menyimpan data download
function simpanDataDownload($namaFile, $gambarPath) {
  global $conn;
  
  // Mendapatkan tanggal dan waktu sekarang
  $tanggalWaktu = date('Y-m-d H:i:s');
  
  // Menyimpan data ke database
  $sql = "INSERT INTO history1 (nama, tanggal, gambar) VALUES (?, ?, ?)";
  
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "sss", $namaFile, $tanggalWaktu, $gambarPath);
  
  if (mysqli_stmt_execute($stmt)) {
      return true;
  } else {
      return false;
  }
}

// Proses jika ada download
if (isset($_GET['download'])) {
  $namaFile = basename($_GET['download']);
  $gambarPath = "/Hapus-BG/app/Admin/downloads/" . $namaFile; // Path yang benar
  
  // Simpan data ke database
  if (simpanDataDownload($namaFile, $gambarPath)) {
      // Lanjutkan proses download
      header('Location: ' . $_GET['download']);
      exit;
  } else {
      die("Failed to save download data.");
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Advanced Background Remover</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="./css/gas.css">
  <link rel="stylesheet" type="text/css" href="./css/Revisi2.css" />
  <script src="script.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
      <!-- Tombol hamburger -->
      <button class="openbtn" onclick="openNav()">☰</button>

      <!-- Sidebar -->
      <div class="sidebar closed">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
      <a href="Revisi2.php#home">Home</a>
      <a href="Revisi2.php#howTo">How To Do It</a>
      <a href="Revisi2.php#Feedback">Feedback</a>
</div>
  <div class="app-container">
    <h1>Background Remover</h1>    
    <div class="controls-container">
      <label for="imageInput" class="file-input-label">
        <i class="fas fa-image"></i> Pilih Gambar
      </label>
      <input type="file" id="imageInput" accept="image/*">
      
      <button class="action-button" id="processBtn">
        <i class="fas fa-magic"></i> Hapus Background
      </button>
      
      <button class="bg-options-toggle" id="bgOptionsToggle">
        <i class="fas fa-sliders-h"></i> Background Options
      </button>
      
      <button id="downloadBtn" class="download-button" style="display: none;">
      <i class="fas fa-download"></i> Download
      </button>

    </div>
    
    <div class="bg-options" id="bgOptions">
      <!-- Slider untuk offset background -->
<div style="margin-top: 15px;">
  <label>Background position:</label>
  <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 8px;">
    <div>
      X: <input type="range" id="bgOffsetX" min="-500" max="500" value="0" step="1">
    </div>
    <div>
      Y: <input type="range" id="bgOffsetY" min="-500" max="500" value="0" step="1">
    </div>
  </div>
</div>

<div id="downloadModal" class="download-modal">
    <div class="download-modal-content">
      <h3><i class="fas fa-download"></i> Download Options</h3>
      
      <div class="download-option">
        <label>Resolution:</label>
        <div class="resolution-options">
          <label><input type="radio" name="resolution" value="original" checked> Original</label><br>
          <label><input type="radio" name="resolution" value="medium"> Medium (50%)</label><br>
          <label><input type="radio" name="resolution" value="low"> Low (25%)</label>
        </div>
      </div>
      
      <div class="save-location">
        <label>Save Location:</label>
        <div style="margin-top: 10px;">
          <label>
            <input type="radio" name="saveMethod" value="download" checked> 
            Download directly
          </label><br>
          <label>
            <input type="radio" name="saveMethod" value="chooseLocation"> 
            Choose location (Chrome/Edge only)
          </label>
        </div>
      </div>
      
      <div class="download-modal-buttons">
        <button id="cancelDownloadBtn" class="download-button">
          <i class="fas fa-times"></i> Cancel
        </button>
        <button id="confirmDownloadBtn" class="action-button">
          <i class="fas fa-save"></i> Save Image
        </button>
      </div>
    </div>
  </div>

      <label for="bgImageInput">
        <i class="fas fa-file-image"></i> Upload Background
      </label>
      <input type="file" id="bgImageInput" accept="image/*">
      
      <div class="color-picker-wrapper">
        <div>Custom Color:</div>
        <div style="position: relative;">
          <input type="color" id="bgColor" value="#ffffff">
          <div class="custom-color-preview" id="colorPreview" style="background-color: #ffffff;"></div>
        </div>
      </div>
      
      <div class="color-options">
        <div class="color-btn" style="background-color: #ffffff;" data-color="#ffffff" title="White"></div>
        <div class="color-btn" style="background-color: #000000;" data-color="#000000" title="Black"></div>
        <div class="color-btn" style="background-color: #3b82f6;" data-color="#3b82f6" title="Blue"></div>
        <div class="color-btn" style="background-color: #ef4444;" data-color="#ef4444" title="Red"></div>
        <div class="color-btn" style="background-color: #10b981;" data-color="#10b981" title="Green"></div>
        <div class="color-btn" style="background-color: #f59e0b;" data-color="#f59e0b" title="Yellow"></div>
        <div class="color-btn" style="background-color: #8b5cf6;" data-color="#8b5cf6" title="Purple"></div>
        <div class="color-btn" style="background-color: #ec4899;" data-color="#ec4899" title="Pink"></div>
      </div>
    </div>
    
    <div class="image-container">
      <canvas id="imageCanvas"></canvas>
      <img id="previewImage" src="#" alt="Preview">
      <div class="placeholder-text" id="placeholder">
        <i class="fas fa-image" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
        <p>Pilih gambar untuk memulai</p>
      </div>
    </div>
    
    <p id="loading">
      <i class="fas fa-spinner fa-spin"></i> Memproses gambar...
    </p>
    
    <div class="brush-tool-container" id="brushToolContainer">
      <div class="brush-controls">
        <button class="brush-btn" id="eraseBtn" title="Erase">
          <i class="fas fa-eraser"></i> Erase
        </button>
        <button class="brush-btn" id="restoreBtn" title="Restore">
          <i class="fas fa-paint-brush"></i> Restore
        </button>
        
        <div class="brush-size-control">
          <span>Brush Size:</span>
          <input type="range" min="5" max="100" value="20" class="brush-size-slider" id="brushSize">
          <div class="brush-size-preview" id="brushPreview"></div>
        </div>
      </div>
      <p class="instructions">Klik dan drag di gambar untuk erase/restore</p>
    </div>
  </div>

  <script>
// DOM Elements
const input = document.getElementById('imageInput');
const preview = document.getElementById('previewImage');
const canvas = document.getElementById('imageCanvas');
const ctx = canvas.getContext('2d');
const container = document.querySelector('.image-container');
const placeholder = document.getElementById('placeholder');
const processBtn = document.getElementById('processBtn');
const downloadBtn = document.getElementById('downloadBtn');
const bgColorPicker = document.getElementById('bgColor');
const colorPreview = document.getElementById('colorPreview');
const bgImageInput = document.getElementById('bgImageInput');
const bgOptionsToggle = document.getElementById('bgOptionsToggle');
const bgOptions = document.getElementById('bgOptions');
const loading = document.getElementById('loading');
const brushToolContainer = document.getElementById('brushToolContainer');
const eraseBtn = document.getElementById('eraseBtn');
const restoreBtn = document.getElementById('restoreBtn');
const brushSizeSlider = document.getElementById('brushSize');
const brushPreview = document.getElementById('brushPreview');
const offsetXInput = document.getElementById('bgOffsetX');
const offsetYInput = document.getElementById('bgOffsetY');
const downloadModal = document.getElementById('downloadModal');
const cancelDownloadBtn = document.getElementById('cancelDownloadBtn');
const confirmDownloadBtn = document.getElementById('confirmDownloadBtn');
let bgOffsetX = 0;
let bgOffsetY = 0;
let selectedResolution = 'original';
let selectedFile = null;
let backgroundImage = null;
let isBgRemoved = false;
let currentBackgroundType = null;
let originalRemovedBgData = null; // After background removal
let originalImageData = null;     // Full original image
let currentTool = null;
let isDrawing = false;
let brushSize = 20;
let processedBlob = null;
let foregroundImage = new Image();
let editedForegroundCanvas = document.createElement('canvas');
let editedForegroundCtx = editedForegroundCanvas.getContext('2d');
let brushCursor = document.createElement('div');
brushCursor.className = 'brush-cursor';
brushCursor.style.display = 'none';
document.body.appendChild(brushCursor);

function init() {
  setupColorButtons();
  setupEventListeners();
  setupBrushTool();
}

function setupColorButtons() {
  document.querySelectorAll('.color-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const color = btn.getAttribute('data-color');
      setBackgroundColor(color);
    });
  });
}

function setBackgroundColor(color) {
  bgColorPicker.value = color;
  colorPreview.style.backgroundColor = color;
  currentBackgroundType = 'color';
  backgroundImage = null;
  bgImageInput.value = '';

  if (isBgRemoved) {
    applyBackground();
  }
}

function setupBrushTool() {
  updateBrushPreview();
  brushSizeSlider.addEventListener('input', updateBrushPreview);
  eraseBtn.addEventListener('click', () => setActiveTool('erase'));
  restoreBtn.addEventListener('click', () => setActiveTool('restore'));

  // Add these mouse event listeners
  canvas.addEventListener('mousemove', updateBrushCursorPosition);
  canvas.addEventListener('mouseenter', showBrushCursor);
  canvas.addEventListener('mouseleave', hideBrushCursor);
  
  canvas.addEventListener('mousedown', startDrawing);
  canvas.addEventListener('mousemove', draw);
  canvas.addEventListener('mouseup', stopDrawing);
  canvas.addEventListener('mouseout', stopDrawing);

  canvas.addEventListener('touchstart', handleTouch);
  canvas.addEventListener('touchmove', handleTouch);
  canvas.addEventListener('touchend', stopDrawing);
}

function updateBrushCursorPosition(e) {
  const rect = canvas.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const y = e.clientY - rect.top;
  
  brushCursor.style.left = `${e.clientX}px`;
  brushCursor.style.top = `${e.clientY}px`;
}

function showBrushCursor() {
  if (currentTool) {
    brushCursor.style.display = 'block';
  }
}

function hideBrushCursor() {
  brushCursor.style.display = 'none';
}

function updateBrushPreview() {
  brushSize = parseInt(brushSizeSlider.value);
  brushPreview.style.width = `${brushSize}px`;
  brushPreview.style.height = `${brushSize}px`;
  
  // Update brush cursor appearance
  brushCursor.style.width = `${brushSize}px`;
  brushCursor.style.height = `${brushSize}px`;
  brushCursor.style.borderColor = currentTool === 'erase' ? 'red' : 'green';
  
  updateCursor();
}

function setActiveTool(tool) {
  currentTool = tool;
  eraseBtn.classList.toggle('active', tool === 'erase');
  restoreBtn.classList.toggle('active', tool === 'restore');
  
  // Update brush cursor color based on tool
  if (tool) {
    brushCursor.style.borderColor = tool === 'erase' ? 'red' : 'green';
    brushCursor.style.display = 'block';
  } else {
    brushCursor.style.display = 'none';
  }
  
  updateCursor();
}

function updateCursor() {
  if (!currentTool) {
    canvas.style.cursor = 'default';
    return;
  }

  const size = Math.max(10, brushSize);
  const color = currentTool === 'erase' ? 'black' : 'white';
  const stroke = currentTool === 'erase' ? '' : 'stroke="black" stroke-width="2"';
  canvas.style.cursor = `url('data:image/svg+xml;utf8,
  <svg xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 100 100">
    <circle cx="50" cy="50" r="50" fill="${color}" ${stroke} opacity="0.7"/>
  </svg>') ${size/2} ${size/2}, crosshair`;
}

function handleTouch(e) {
  e.preventDefault();
  const touch = e.touches[0];
  const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' : 'mousemove', {
    clientX: touch.clientX,
    clientY: touch.clientY
  });
  canvas.dispatchEvent(mouseEvent);
}

function startDrawing(e) {
  if (!currentTool || !isBgRemoved) return;
  isDrawing = true;
  
  // Get accurate position considering canvas scaling
  const rect = canvas.getBoundingClientRect();
  const scaleX = canvas.width / rect.width;
  const scaleY = canvas.height / rect.height;
  
  lastX = (e.clientX - rect.left) * scaleX;
  lastY = (e.clientY - rect.top) * scaleY;
  
  draw(e);
}

function draw(e) {
  if (!isDrawing || !currentTool) return;

  const rect = canvas.getBoundingClientRect();
  const scaleX = canvas.width / rect.width;
  const scaleY = canvas.height / rect.height;
  
  const x = (e.clientX - rect.left) * scaleX;
  const y = (e.clientY - rect.top) * scaleY;

  if (currentTool === 'erase') {
    // Draw on our edited foreground canvas
    editedForegroundCtx.globalCompositeOperation = 'destination-out';
    editedForegroundCtx.beginPath();
    editedForegroundCtx.arc(x, y, brushSize / 2, 0, Math.PI * 2);
    editedForegroundCtx.fill();
  } else if (currentTool === 'restore' && originalImageData) {
    // Restore from original image data
    const imageData = editedForegroundCtx.getImageData(0, 0, editedForegroundCanvas.width, editedForegroundCanvas.height);
    const originalData = originalImageData.data;
    const data = imageData.data;

    const startX = Math.max(0, Math.floor(x - brushSize / 2));
    const startY = Math.max(0, Math.floor(y - brushSize / 2));
    const endX = Math.min(editedForegroundCanvas.width, Math.floor(x + brushSize / 2));
    const endY = Math.min(editedForegroundCanvas.height, Math.floor(y + brushSize / 2));

    for (let py = startY; py < endY; py++) {
      for (let px = startX; px < endX; px++) {
        const dx = px - x;
        const dy = py - y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        if (distance <= brushSize / 2) {
          const index = (py * editedForegroundCanvas.width + px) * 4;
          data[index]     = originalData[index];     // R
          data[index + 1] = originalData[index + 1]; // G
          data[index + 2] = originalData[index + 2]; // B
          data[index + 3] = originalData[index + 3]; // A
        }
      }
    }

    editedForegroundCtx.putImageData(imageData, 0, 0);
  }

  // Update the main canvas display
  applyBackground();
  
  // Update last position
  lastX = x;
  lastY = y;
}

function stopDrawing() {
  isDrawing = false;
  updateProcessedBlob();
}

function updateProcessedBlob() {
  canvas.toBlob(blob => {
    processedBlob = blob;
  }, 'image/png');
}

function setupEventListeners() {
  bgOptionsToggle.addEventListener('click', () => {
    bgOptions.classList.toggle('show');
  });

  bgColorPicker.addEventListener('input', () => {
    colorPreview.style.backgroundColor = bgColorPicker.value;
    currentBackgroundType = 'color';
    backgroundImage = null;
    bgImageInput.value = '';
    if (isBgRemoved) applyBackground();
  });

  colorPreview.addEventListener('click', () => {
    bgColorPicker.click();
  });

  input.addEventListener('change', handleImageUpload);

  bgImageInput.addEventListener('change', function () {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        backgroundImage = new Image();
        backgroundImage.src = e.target.result;
        backgroundImage.onload = () => {
          currentBackgroundType = 'image';
          if (isBgRemoved) applyBackground();
        };
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

  processBtn.addEventListener('click', processImage);

  downloadBtn.addEventListener('click', function(e) {
  e.preventDefault();
  e.stopPropagation();
  downloadModal.classList.add('show');
});

// Tutup modal ketika klik di luar
downloadModal.addEventListener('click', function(e) {
  if (e.target === downloadModal) {
    downloadModal.classList.remove('show');
  }
});

// Tutup modal dengan tombol cancel
cancelDownloadBtn.addEventListener('click', function(e) {
  e.stopPropagation();
  downloadModal.classList.remove('show');
});

  cancelDownloadBtn.addEventListener('click', () => {
    downloadModal.classList.remove('show');
  });

  confirmDownloadBtn.addEventListener('click', async () => {
    const resolution = document.querySelector('input[name="resolution"]:checked').value;
    const saveMethod = document.querySelector('input[name="saveMethod"]:checked').value;
    
    downloadModal.classList.remove('show');
    await handleDownload(resolution, saveMethod);
  });
}

async function handleDownload(resolution, saveMethod) {
  let scale = 1;
  if (resolution === 'medium') scale = 0.5;
  else if (resolution === 'low') scale = 0.25;

  const downloadCanvas = document.createElement('canvas');
  downloadCanvas.width = canvas.width * scale;
  downloadCanvas.height = canvas.height * scale;
  const downloadCtx = downloadCanvas.getContext('2d');
  
  // Draw background first
  if (currentBackgroundType === 'image' && backgroundImage) {
    const bgAspect = backgroundImage.width / backgroundImage.height;
    const canvasAspect = downloadCanvas.width / downloadCanvas.height;

    let drawWidth, drawHeight, offsetX = 0, offsetY = 0;

    if (bgAspect > canvasAspect) {
      drawHeight = downloadCanvas.height;
      drawWidth = backgroundImage.width * (downloadCanvas.height / backgroundImage.height);
      offsetX = (downloadCanvas.width - drawWidth) / 2;
    } else {
      drawWidth = downloadCanvas.width;
      drawHeight = backgroundImage.height * (downloadCanvas.width / backgroundImage.width);
      offsetY = (downloadCanvas.height - drawHeight) / 2;
    }

    downloadCtx.drawImage(backgroundImage, 
      offsetX + bgOffsetX * scale, 
      offsetY + bgOffsetY * scale, 
      drawWidth, 
      drawHeight);
  } else if (currentBackgroundType === 'color') {
    downloadCtx.fillStyle = bgColorPicker.value;
    downloadCtx.fillRect(0, 0, downloadCanvas.width, downloadCanvas.height);
  }
  
  // Then draw the edited foreground
  downloadCtx.drawImage(editedForegroundCanvas, 0, 0, downloadCanvas.width, downloadCanvas.height);

  const blob = await new Promise(resolve => {
    downloadCanvas.toBlob(resolve, 'image/png');
  });

  const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
  const filename = `bg-removed-${timestamp}.png`;

  try {
    const formData = new FormData();
    formData.append('filename', filename);
    
    const base64data = await blobToBase64(blob);
    formData.append('imagedata', base64data);
    
    const response = await fetch('/Hapus-BG/app/Admin/save_download.php', {
      method: 'POST',
      body: formData
    });
    
    const result = await response.json();
    
    if (result.status !== 'success') {
      console.error('Failed to save to database:', result.message);
    }
  } catch (error) {
    console.error('Error saving to database:', error);
  }

  if (saveMethod === 'chooseLocation' && 'showSaveFilePicker' in window) {
    try {
      const handle = await window.showSaveFilePicker({
        suggestedName: filename,
        types: [{
          description: 'PNG Image',
          accept: {'image/png': ['.png']}
        }]
      });
      
      const writable = await handle.createWritable();
      await writable.write(blob);
      await writable.close();
      
      Swal.fire({
        icon: 'success',
        title: 'success',
        text: 'picture succesfully saved',
        timer: 1500,
        showConfirmButton: false
      });
    } catch (err) {
      if (err.name !== 'AbortError') {
        console.error('Error saving file:', err);
        triggerDownload(blob, filename);
      }
    }
  } else {
    triggerDownload(blob, filename);
  }
}

async function triggerDownload(blob, filename) {
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = filename;
  document.body.appendChild(a);
  a.click();
  
  Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: 'Gambar berhasil diunduh',
    timer: 1500,
    showConfirmButton: false
  });
  
  setTimeout(() => {
    document.body.removeChild(a);
    URL.revokeObjectURL(a.href);
  }, 100);
}

function blobToBase64(blob) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onloadend = () => resolve(reader.result);
    reader.onerror = reject;
    reader.readAsDataURL(blob);
  });
}

offsetXInput.addEventListener('input', () => {
  bgOffsetX = parseInt(offsetXInput.value);
  if (isBgRemoved) applyBackground();
});

offsetYInput.addEventListener('input', () => {
  bgOffsetY = parseInt(offsetYInput.value);
  if (isBgRemoved) applyBackground();
});

function handleImageUpload() {/*menyimpan data gambar asli, membaca file, download button hide(karna blm hapus bg), hide toolbrush, atur uukuran kanvas,dll*/
  if (this.files && this.files[0]) {
    selectedFile = this.files[0];
    const reader = new FileReader();
    reader.onload = function (e) {
      const img = new Image();
      img.onload = function () {
        canvas.width = img.width;
        canvas.height = img.height;
        editedForegroundCanvas.width = img.width;
        editedForegroundCanvas.height = img.height;
        ctx.drawImage(img, 0, 0);

        originalImageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

        placeholder.style.display = 'none';
        preview.style.display = 'none';
        canvas.style.display = 'block';

        downloadBtn.style.display = 'none';
        processBtn.textContent = "Hapus Background";
        isBgRemoved = false;
        backgroundImage = null;
        bgImageInput.value = '';
        currentBackgroundType = null;

        brushToolContainer.classList.remove('show');
        currentTool = null;
        eraseBtn.classList.remove('active');
        restoreBtn.classList.remove('active');
        updateCursor();
      };
      img.src = e.target.result;
      preview.src = e.target.result;
    };
    reader.readAsDataURL(selectedFile);
  }
  this.value = '';
}

async function processImage() {
  if (!selectedFile) {
    alert("Silakan pilih gambar terlebih dahulu!");
    return;
  }

  loading.style.display = 'block';
  loading.textContent = "⏳ Deleting background...";

  try {
    const formData = new FormData();
    formData.append('input_image', selectedFile);

    const response = await fetch('http://127.0.0.1:5000/process-image', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) throw new Error(await response.text());

    const resultBlob = await response.blob();
    await displayResultImage(resultBlob);

    isBgRemoved = true;
    processBtn.textContent = "processing";
    brushToolContainer.classList.add('show');

    // Set default background color putih
    setBackgroundColor('#ffffff');
    
    downloadBtn.style.display = 'inline-block';
  } catch (err) {
    console.error("Error:", err);
    alert('Error: ' + (err.message || 'Gagal memproses gambar'));
  } finally {
    loading.style.display = 'none';
  }
}

async function displayResultImage(blob) {
  return new Promise((resolve) => {
    foregroundImage.onload = () => {
      canvas.width = foregroundImage.width;
      canvas.height = foregroundImage.height;
      editedForegroundCanvas.width = foregroundImage.width;
      editedForegroundCanvas.height = foregroundImage.height;
      
      // Clear dan gambar foreground image ke edited canvas
      editedForegroundCtx.clearRect(0, 0, editedForegroundCanvas.width, editedForegroundCanvas.height);
      editedForegroundCtx.drawImage(foregroundImage, 0, 0);
      
      // Simpan data asli setelah remove bg
      originalRemovedBgData = editedForegroundCtx.getImageData(0, 0, editedForegroundCanvas.width, editedForegroundCanvas.height);
      
      // Langsung apply background putih default
      applyBackground();
      resolve();
    };
    foregroundImage.src = URL.createObjectURL(blob);
  });
}

function applyBackground() {
  if (!isBgRemoved) return;

  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Gambar background terlebih dahulu
  if (currentBackgroundType === 'image' && backgroundImage) {
    const bgAspect = backgroundImage.width / backgroundImage.height;
    const canvasAspect = canvas.width / canvas.height;

    let drawWidth, drawHeight, offsetX = 0, offsetY = 0;

    if (bgAspect > canvasAspect) {
      drawHeight = canvas.height;
      drawWidth = backgroundImage.width * (canvas.height / backgroundImage.height);
      offsetX = (canvas.width - drawWidth) / 2;
    } else {
      drawWidth = canvas.width;
      drawHeight = backgroundImage.height * (canvas.width / backgroundImage.width);
      offsetY = (canvas.height - drawHeight) / 2;
    }

    ctx.drawImage(backgroundImage, offsetX + bgOffsetX, offsetY + bgOffsetY, drawWidth, drawHeight);
  } else if (currentBackgroundType === 'color') {
    ctx.fillStyle = bgColorPicker.value;
    ctx.fillRect(0, 0, canvas.width, canvas.height);
  }
  
  // Gambar foreground yang sudah di-edit
  ctx.drawImage(editedForegroundCanvas, 0, 0);
  
  updateProcessedBlob();
}

// Init app
init();

  </script>
</body>
</html>