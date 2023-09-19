(function () {
  "use strict";

  var items = [
    "../../../public/images/house/DINO_THUNDERS.png",
    "../../../public/images/house/DRAGON_WARRIORS.png",
    "../../../public/images/house/PHOENIX_BLASTERS.png",
    "../../../public/images/house/TIGER_THRASHERS.png",
  ];

  var slot = [];
  let temp;
  document.querySelector(".info").textContent = items.join(" ");

  const doors = document.querySelectorAll(".door");
  document.querySelector("#spinner").addEventListener("click", spin);
  document.querySelector("#reseter").addEventListener("click", init);

  var itemNo = 0;

  async function spin() {
    init(false, 1, 2);
    const boxes = doors[itemNo].querySelector(".boxes");
    const duration = parseInt(boxes.style.transitionDuration);
    boxes.style.transform = "translateY(0)";
    itemNo = itemNo + 1;
    // for (const door of doors) {
    //   const boxes = door.querySelector(".boxes");
    //   const duration = parseInt(boxes.style.transitionDuration);
    //   boxes.style.transform = "translateY(0)";
    //   await new Promise((resolve) => setTimeout(resolve, duration * 200));
    // }
  }

  function init(firstInit = true, groups = 1, duration = 1) {
    for (const door of doors) {
      if (firstInit) {
        door.dataset.spinned = "0";
      } else if (door.dataset.spinned === "1") {
        return;
      }

      const boxes = door.querySelector(".boxes");
      const boxesClone = boxes.cloneNode(false);

      const pool = ["https://cdn.pixabay.com/animation/2023/01/07/11/02/11-02-30-972_512.gif"];

      if (!firstInit) {
        const arr = [];
        for (let n = 0; n < (groups > 0 ? groups : 1); n++) {
          arr.push(...items);
        }
        pool.push(...shuffle(arr));

        boxesClone.addEventListener(
          "transitionstart",
          function () {
            door.dataset.spinned = "1";
            this.querySelectorAll(".box").forEach((box) => {
              box.style.filter = "blur(1px)";
            });
          },
          { once: true }
        );

        boxesClone.addEventListener(
          "transitionend",
          function () {
            this.querySelectorAll(".box").forEach((box, index) => {
              box.style.filter = "blur(0)";
              if (index > 0) {
                this.removeChild(box);
              }
            });
          },
          { once: true }
        );
      }
      // console.log(pool);

      for (let i = pool.length - 1; i >= 0; i--) {
        const box = document.createElement("img");
        box.classList.add("box");
        box.style.color = "black";
        // box.style.width = door.clientWidth + "px";
        box.style.height = door.clientHeight + "px";
        box.src = pool[i];
        boxesClone.appendChild(box);
      }
      boxesClone.style.transitionDuration = `${duration > 0 ? duration : 1}s`;
      boxesClone.style.transform = `translateY(-${
        door.clientHeight * (pool.length - 1)
      }px)`;
      door.replaceChild(boxesClone, boxes);
      // console.log(door);
      pool.forEach((element) => {
        temp = element;
      });
      // items.remove(temp);
      var pos = items.findIndex((val) => val == temp);
      if (pos != -1) {
        items.splice(pos, 1);
        slot.push(temp);
      }
    }
    document.getElementById("slot").value = slot;
  }

  function shuffle([...arr]) {
    let m = arr.length;
    while (m) {
      const i = Math.floor(Math.random() * m--);
      [arr[m], arr[i]] = [arr[i], arr[m]];
    }
    return arr;
  }

  init();
})();
