<style>
  canvas {
    background-color: #fffae7; /* สีไข่ (Eggshell) */
    box-shadow: -1px 10px 20px rgb(0 0 0 / 13%);
    border-radius: 10px; /* ขอบโค้งมน */
    cursor: crosshair; /* เคอร์เซอร์ปกติ */
  }

  .controls {
    margin: 10px;
  }
  main#main {
    background: #ffffff;
    margin-top: 0px;
  }
  #header {
    display: none !important;
  }
  .eraser-mode {
    cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser" viewBox="0 0 16 16"><path d="M8.086.586a2 2 0 0 1 2.828 0l5.499 5.499a2 2 0 0 1 0 2.828l-8.5 8.5a2 2 0 0 1-2.828 0l-5.5-5.5a2 2 0 0 1 0-2.828l8.5-8.5ZM6.732 15.45a1 1 0 0 0 1.415 0L14.5 9.096 6.904 1.5 1.5 6.904l5.232 5.232L6 13.268l.732.732ZM12.096 8.5 13.5 9.904 14.268 9.5 12.096 8.5Z"/></svg>') 16 16, auto;
  }
</style>
<div class="controls">
  <label for="color">เลือกสี:</label>
  <input type="color" id="color" value="#000000">
  <label for="size">ขนาดเส้น:</label>
  <input type="range" id="size" min="1" max="20" value="3">
  <button id="clear">ล้างทั้งหมด</button>
  <button id="undo">ย้อนกลับ</button>
  <button id="erase">ยางลบ</button> <!-- ปุ่มยางลบ -->
  <button id="speak">อ่านข้อความ</button>
  <span>ดับเบิ้ลคลิกบนพื้นที่วาดเพื่อเพิ่มข้อความ</span>
</div>
<canvas id="drawingCanvas" width="1200" height="600"></canvas>
<script>
const canvas = document.getElementById('drawingCanvas');
const ctx = canvas.getContext('2d');
const colorPicker = document.getElementById('color');
const sizePicker = document.getElementById('size');
const clearBtn = document.getElementById('clear');
const undoBtn = document.getElementById('undo');
const eraseBtn = document.getElementById('erase');
const speakBtn = document.getElementById('speak');

let drawing = false;
let erasing = false;
let undoStack = [];
let isDraggingText = false;
let draggingText = null;
let offsetX = 0;
let offsetY = 0;
let texts = []; // เก็บข้อความพร้อมตำแหน่ง
let drawings = []; // เก็บเส้นที่วาดไว้

// ฟังก์ชันเก็บสถานะ
function saveState() {
  try {
    const state = {
      image: canvas.toDataURL('image/png'), // เก็บภาพในรูปแบบ Base64
      texts: JSON.parse(JSON.stringify(texts)), // เก็บข้อมูล texts
      drawings: JSON.parse(JSON.stringify(drawings)) // เก็บข้อมูล drawings
    };

    // ตรวจสอบว่าค่า image เป็น Base64 URL ที่ถูกต้อง
    if (typeof state.image !== 'string' || !state.image.startsWith('data:image')) {
      console.error('Invalid image data:', state.image);
      return; // หยุดการบันทึกหากข้อมูลไม่ถูกต้อง
    }

    undoStack.push(state);
    console.log('State saved:', state); // ตรวจสอบสถานะที่บันทึก

    if (undoStack.length > 20) {
      undoStack.shift(); // จำกัด Undo stack ไม่เกิน 20 สถานะ
    }
  } catch (error) {
    console.error('Error saving state:', error); // ตรวจสอบข้อผิดพลาด
  }
}





// ฟังก์ชันเริ่มวาด
function startDrawing(e) {
  if (!isDraggingText && !erasing) {
    saveState();
    drawing = true;
    drawings.push([]);
    ctx.beginPath();
    ctx.moveTo(e.offsetX, e.offsetY);
  }
}

// ฟังก์ชันวาด
function draw(e) {
  if (!drawing) return;

  ctx.lineWidth = sizePicker.value;
  ctx.strokeStyle = colorPicker.value;
  ctx.lineTo(e.offsetX, e.offsetY);
  ctx.stroke();

  drawings[drawings.length - 1].push({
    x: e.offsetX,
    y: e.offsetY,
    color: colorPicker.value,
    lineWidth: sizePicker.value
  });
}

// หยุดวาด
function stopDrawing() {
  drawing = false;
  ctx.closePath();
}

// ฟังก์ชันตรวจสอบการลบและลบเส้นหรือข้อความ
function eraseContent(e) {
  const mouseX = e.offsetX;
  const mouseY = e.offsetY;

  // ลบข้อความถ้าคลิกในบริเวณของข้อความ
  for (let i = texts.length - 1; i >= 0; i--) {
    const t = texts[i];
    ctx.font = `${t.fontSize}px 'Sarabun', sans-serif`;
    const textWidth = ctx.measureText(t.text).width;
    const textHeight = t.fontSize;

    if (mouseX >= t.x && mouseX <= t.x + textWidth && mouseY >= t.y - textHeight && mouseY <= t.y) {
      texts.splice(i, 1); // ลบข้อความ
      redrawCanvas();
      return;
    }
  }

  // ลบเส้นถ้าคลิกในบริเวณใกล้เคียง
  for (let i = drawings.length - 1; i >= 0; i--) {
    const segment = drawings[i];
    for (let j = 0; j < segment.length; j++) {
      const point = segment[j];
      const distance = Math.sqrt((point.x - mouseX) ** 2 + (point.y - mouseY) ** 2);
      
      // เพิ่ม hitbox ของยางลบให้กว้างขึ้น
      if (distance < sizePicker.value * 4) { // ขยายระยะให้ตรวจจับง่ายขึ้น
        drawings.splice(i, 1); // ลบ segment ทั้งหมด
        redrawCanvas();
        return;
      }
    }
  }
}


// เปิด/ปิดโหมดยางลบ
eraseBtn.addEventListener('click', () => {
  erasing = !erasing;
  eraseBtn.textContent = erasing ? 'หยุดยางลบ' : 'ยางลบ';
  if (erasing) {
    canvas.classList.add('eraser-mode'); // เพิ่มคลาสยางลบ
  } else {
    canvas.classList.remove('eraser-mode'); // เอาคลาสยางลบออก
  }
});


// ฟังก์ชัน Redraw Canvas ทั้งหมด
function redrawCanvas() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  drawings.forEach(segment => {
    if (segment.length > 0) {
      ctx.beginPath();
      ctx.moveTo(segment[0].x, segment[0].y);
      segment.forEach(point => {
        ctx.lineTo(point.x, point.y);
      });
      ctx.strokeStyle = segment[0].color;
      ctx.lineWidth = segment[0].lineWidth;
      ctx.stroke();
    }
  });

  texts.forEach(t => {
    ctx.fillStyle = t.color;
    ctx.font = `${t.fontSize}px 'Sarabun', sans-serif`;
    ctx.fillText(t.text, t.x, t.y);
  });
}


// เพิ่มข้อความ
function addText(e) {
  saveState();
  Swal.fire({
    title: 'เพิ่มข้อความ',
    input: 'textarea',
    inputLabel: 'กรุณาใส่ข้อความที่ต้องการเพิ่ม',
    inputPlaceholder: 'พิมพ์ข้อความที่นี่...',
    showCancelButton: true,
    confirmButtonText: 'เพิ่มข้อความ',
    cancelButtonText: 'ยกเลิก',
    customClass: {
      popup: 'swal2-large-popup'
    },
    preConfirm: (value) => {
      if (!value) {
        Swal.showValidationMessage('กรุณาใส่ข้อความก่อนบันทึก');
      }
      return value;
    },
    didOpen: () => {
      const textarea = Swal.getInput();
      textarea.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
          event.preventDefault();
          Swal.clickConfirm();
        }
      });
    }
  }).then((result) => {
    if (result.isConfirmed && result.value) {
      const text = result.value;
      const posX = e.offsetX;
      const posY = e.offsetY;

      ctx.fillStyle = colorPicker.value;
      ctx.font = `${sizePicker.value * 5}pt 'Sarabun', sans-serif`;
      ctx.fillText(text, posX, posY);

      texts.push({
        text: text,
        x: posX,
        y: posY,
        color: colorPicker.value,
        fontSize: sizePicker.value * 5
      });

      redrawCanvas();
    }
  });
}

// เริ่มลากข้อความ
canvas.addEventListener('mousedown', (e) => {
  if (erasing) {
    eraseContent(e);
  } else {
    const mouseX = e.offsetX;
    const mouseY = e.offsetY;

    for (let i = texts.length - 1; i >= 0; i--) {
      const t = texts[i];
      ctx.font = `${t.fontSize}px 'Sarabun', sans-serif`;
      const textWidth = ctx.measureText(t.text).width;
      const textHeight = t.fontSize;

      if (mouseX >= t.x && mouseX <= t.x + textWidth && mouseY >= t.y - textHeight && mouseY <= t.y) {
        draggingText = t;
        offsetX = mouseX - t.x;
        offsetY = mouseY - t.y;
        isDraggingText = true;
        return;
      }
    }

    startDrawing(e);
  }
});

// ฟังก์ชันลากข้อความ
canvas.addEventListener('mousemove', (e) => {
  if (isDraggingText && draggingText) {
    draggingText.x = e.offsetX - offsetX;
    draggingText.y = e.offsetY - offsetY;
    redrawCanvas();
  } else if (drawing) {
    draw(e);
  }
});

// หยุดลากข้อความหรือวาดเส้น
canvas.addEventListener('mouseup', () => {
  if (isDraggingText) {
    isDraggingText = false;
    draggingText = null;
  } else if (drawing) {
    stopDrawing();
  }
});

// ดับเบิ้ลคลิกเพื่อเพิ่มข้อความ
canvas.addEventListener('dblclick', (e) => {
  addText(e);
});

// ล้างทั้งหมด
clearBtn.addEventListener('click', () => {
  saveState(); // เก็บสถานะก่อนล้าง
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  texts = [];
  drawings = [];
  undoStack = []; // รีเซ็ต Undo stack
  console.log('Canvas cleared and Undo stack reset');
});

// ย้อนกลับ
undoBtn.addEventListener('click', () => {
  if (undoStack.length > 0) {
    const lastState = undoStack.pop();
    const img = new Image();
    img.src = lastState;
    img.onload = () => {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(img, 0, 0);
    };
  }
  undo();
});

function undo() {
  if (undoStack.length > 0) {
    const lastState = undoStack.pop(); // ดึงสถานะล่าสุดจาก undoStack

    if (!lastState.image || typeof lastState.image !== 'string' || !lastState.image.startsWith('data:image')) {
      console.error('Invalid image data in undo state:', lastState.image);
      return;
    }

    const img = new Image();
    img.src = lastState.image; // ตั้งค่า src ด้วย Base64 Data URL

    img.onload = () => {
      ctx.clearRect(0, 0, canvas.width, canvas.height); // ล้าง canvas
      ctx.drawImage(img, 0, 0); // วาดภาพที่ Undo กลับมา
      texts = lastState.texts || []; // คืนค่า texts
      drawings = lastState.drawings || []; // คืนค่า drawings
      console.log('Undo successful:', { texts, drawings });
    };

    img.onerror = () => {
      console.error('Failed to load image for undo. Image source:', img.src);
    };
  } else {
    console.log('Undo stack is empty'); // แจ้งเตือนเมื่อไม่มีสถานะใน undoStack
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    texts = [];
    drawings = [];
  }
}



</script>