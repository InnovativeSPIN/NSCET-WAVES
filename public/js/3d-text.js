var height,
  width,
  container,
  scene,
  camera,
  renderer,
  particles = [],
  mouseVector = new THREE.Vector3(0, 0, 0),
  mousePos = new THREE.Vector3(0, 0, 0),
  cameraLookAt = new THREE.Vector3(0, 0, 0),
  cameraTarget = new THREE.Vector3(0, 0, 800),
  textCanvas,
  textCtx,
  textPixels = [],
  input;

var colors = ["#db4e98", "#24fdc3", "#0ee1e7", "#ef235c", "#0ee1e7", "#38bdf8"];

function initStage() {
  container = document.getElementById("stage");
  if (!container) return false;
  
  width = Math.min(container.clientWidth || window.innerWidth || 1000, 1100);
  if (width < 320) width = 320;
  height = 260;

  container.addEventListener("mousemove", mousemove);
  window.addEventListener("resize", function () {
    if (container && renderer && camera) {
      width = Math.min(container.clientWidth || window.innerWidth || 1000, 1100);
      camera.aspect = width / height;
      camera.updateProjectionMatrix();
      renderer.setSize(width, height);
      if (textCanvas) {
        textCanvas.style.width = width + "px";
        textCanvas.width = width;
      }
      updateText();
    }
  });
  return true;
}

function initScene() {
  if (!container) return;
  scene = new THREE.Scene();
  renderer = new THREE.WebGLRenderer({
    alpha: true,
    antialias: true,
  });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.setSize(width, height);
  container.innerHTML = "";
  container.appendChild(renderer.domElement);
}

function randomPos(vector) {
  var radius = width * 3;
  var centerX = 0;
  var centerY = 0;

  var r = width + radius * Math.random();
  var angle = Math.random() * Math.PI * 2;

  vector.x = centerX + r * Math.cos(angle);
  vector.y = centerY + r * Math.sin(angle);
}

function initCamera() {
  var fieldOfView = 70;
  var aspectRatio = width / height;
  var nearPlane = 1;
  var farPlane = 3000;
  camera = new THREE.PerspectiveCamera(
    fieldOfView,
    aspectRatio,
    nearPlane,
    farPlane
  );
  camera.position.z = 800;
}

function createLights() {
  var shadowLight = new THREE.DirectionalLight(0xffffff, 2);
  shadowLight.position.set(20, 0, 10);
  shadowLight.castShadow = true;
  scene.add(shadowLight);

  var light = new THREE.DirectionalLight(0xffffff, 0.7);
  light.position.set(-20, 0, 20);
  scene.add(light);

  var backLight = new THREE.DirectionalLight(0x0de1eb, 0.9);
  backLight.position.set(0, 0, -20);
  scene.add(backLight);
}

function Particle() {
  this.vx = Math.random() * 0.07;
  this.vy = Math.random() * 0.07;
}

Particle.prototype.init = function (i) {
  var particle = new THREE.Object3D();
  var geometryCore = new THREE.BoxGeometry(20, 20, 20);
  var materialCore = new THREE.MeshLambertMaterial({
    color: colors[i % colors.length],
    shading: THREE.FlatShading,
  });
  var box = new THREE.Mesh(geometryCore, materialCore);
  box.geometry.__dirtyVertices = true;
  box.geometry.dynamic = true;
  particle.targetPosition = new THREE.Vector3(
    (textPixels[i].x - width / 2) * 4,
    textPixels[i].y * 5,
    -10 * Math.random() + 20
  );
  particle.position.set(width * 0.5, height * 0.5, -10 * Math.random() + 20);
  randomPos(particle.position);

  for (var j = 0; j < box.geometry.vertices.length; j++) {
    box.geometry.vertices[j].x += -10 + Math.random() * 20;
    box.geometry.vertices[j].y += -10 + Math.random() * 20;
    box.geometry.vertices[j].z += -10 + Math.random() * 20;
  }

  particle.add(box);
  this.particle = particle;
};

Particle.prototype.updateRotation = function () {
  this.particle.rotation.x += this.vx;
  this.particle.rotation.y += this.vy;
};

Particle.prototype.updatePosition = function () {
  this.particle.position.lerp(this.particle.targetPosition, 0.02);
};

function render() {
  if (renderer && scene && camera) {
    renderer.render(scene, camera);
  }
}

function updateParticles() {
  for (var i = 0, l = particles.length; i < l; i++) {
    if (particles[i]) {
      particles[i].updateRotation();
      particles[i].updatePosition();
    }
  }
}

function setParticles() {
  for (var i = 0; i < textPixels.length; i++) {
    if (particles[i]) {
      particles[i].particle.targetPosition.x =
        (textPixels[i].x - width / 2) * 4;
      particles[i].particle.targetPosition.y = textPixels[i].y * 5;
      particles[i].particle.targetPosition.z = -10 * Math.random() + 20;
    } else {
      var p = new Particle();
      p.init(i);
      scene.add(p.particle);
      particles[i] = p;
    }
  }

  for (var k = textPixels.length; k < particles.length; k++) {
    if (particles[k]) {
      randomPos(particles[k].particle.targetPosition);
    }
  }
}

function initCanvas() {
  textCanvas = document.getElementById("text");
  var wavesTextCanvas = document.getElementById("waves-text");

  if (wavesTextCanvas) {
    wavesTextCanvas.style.display = "none";
  }

  if (!textCanvas) return;

  textCanvas.style.width = width + "px";
  textCanvas.style.height = height + "px";
  textCanvas.width = width;
  textCanvas.height = height;
  textCtx = textCanvas.getContext("2d");
  textCtx.font = "900 100px 'Outfit', 'ShantellSans', sans-serif";
  textCtx.fillStyle = "#555";
}

function initInput() {
  input = document.getElementById("input");
  if (input) {
    input.addEventListener("keyup", updateText);
    input.value = "WAVES'2K26";
  }
}

function updateText() {
  if (!textCtx) return;
  var val = (input && input.value) ? input.value.trim() : "WAVES'2k26";
  var fontSize = Math.floor(width / (val.length * 1.15));
  if (fontSize > 115) fontSize = 115;
  if (fontSize < 45) fontSize = 45;

  textCtx.font = "900 " + fontSize + "px 'Outfit', 'ShantellSans', sans-serif";
  textCtx.clearRect(0, 0, width, height);
  textCtx.textAlign = "center";
  textCtx.textBaseline = "middle";
  textCtx.fillText(val.toUpperCase(), width / 2, 60);

  var pix = textCtx.getImageData(0, 0, width, height).data;
  textPixels = [];
  var step = width < 600 ? 8 : 6;
  for (var i = pix.length; i >= 0; i -= 4) {
    if (pix[i] !== 0) {
      var x = (i / 4) % width;
      var y = Math.floor(Math.floor(i / width) / 4);

      if (x && x % step === 0 && y && y % step === 0) {
        textPixels.push({
          x: x,
          y: 200 - y - 120,
        });
      }
    }
  }
  setParticles();
}

function mousemove(e) {
  var x = e.pageX - width / 2;
  var y = e.pageY - height / 2;
  cameraTarget.x = x * -1;
  cameraTarget.y = y;

  if (textCanvas && e.target === textCanvas && textCtx && input) {
    var rect = textCanvas.getBoundingClientRect();
    var mouseX = e.clientX - rect.left;
    var mouseY = e.clientY - rect.top;

    var textWidth = textCtx.measureText(input.value.toUpperCase()).width;
    var textHeight = 100;
    var textX = (width - textWidth) / 2;
    var textY = 60;
    if (
      mouseX > textX &&
      mouseX < textX + textWidth &&
      mouseY > textY - textHeight / 2 &&
      mouseY < textY + textHeight / 2
    ) {
      for (var i = particles.length - 1; i >= 0; i--) {
        scene.remove(particles[i].particle);
        particles.splice(i, 1);
      }
    }
  }
}

function animate() {
  requestAnimationFrame(animate);
  updateParticles();
  if (camera) {
    camera.position.lerp(cameraTarget, 0.2);
    camera.lookAt(cameraLookAt);
  }
  render();

  for (var i = 0; i < particles.length; i++) {
    if (particles[i]) {
      particles[i].particle.position.z += Math.random() * 0.1 - 0.05;
      particles[i].particle.rotation.x += Math.random() * 0.01 - 0.005;
      particles[i].particle.rotation.y += Math.random() * 0.01 - 0.005;
    }
  }
}

function initAll() {
  if (!initStage()) return;
  initScene();
  initCanvas();
  initCamera();
  createLights();
  initInput();
  animate();
  updateText();

  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(function () {
      updateText();
    });
  }
  setTimeout(updateText, 100);
  setTimeout(updateText, 500);
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initAll);
} else {
  initAll();
}
