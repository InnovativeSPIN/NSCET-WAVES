let sl = 0;

let startersbutton = document.getElementById("startersbutton");
let mainsbutton = document.getElementById("mainsbutton");
let dessertsbutton = document.getElementById("dessertsbutton");
let drinksbutton = document.getElementById("drinksbutton");

let phoenix = document.getElementById("phoenix");
let rosy = document.getElementById("rosy");
let tiger = document.getElementById("tiger");
let violet = document.getElementById("violet");

let ni1 = document.getElementById("ni1");
let ni2 = document.getElementById("ni2");
let ni3 = document.getElementById("ni3");
let ni4 = document.getElementById("ni4");
let ni5 = document.getElementById("ni5");
let ni6 = document.getElementById("ni6");
let ni7 = document.getElementById("ni7");
let ni8 = document.getElementById("ni8");

startersbutton.addEventListener("click", (e) => {
	setIndicator(0);
});
mainsbutton.addEventListener("click", (e) => {
	setIndicator(1);
});
dessertsbutton.addEventListener("click", (e) => {
	setIndicator(2);
});
drinksbutton.addEventListener("click", (e) => {
	setIndicator(3);
});

phoenix.addEventListener("click", (e) => {
	setIndicator(4);
});
rosy.addEventListener("click", (e) => {
	setIndicator(5);
});
tiger.addEventListener("click", (e) => {
	setIndicator(6);
});
violet.addEventListener("click", (e) => {
	setIndicator(7);
});


function populateItems(eventData, houseName) {
    let menu = document.querySelector(".menu");
    menu.innerHTML = "";

    if (eventData.event) {
        const event = eventData.event;

        if (event.is_group === "0") {
            createEventTable(eventData.participants, houseName, menu,'Event Details');
        } else if (event.is_group === "1") {
            const groups = eventData.groups;

			var groupCount = eventData.event.group_counts
            for (const group of groups) {
                if (group.participants && group.participants.length > 0) {
                    createEventTable(group.participants, houseName, menu,`Group ${group.group_number} Details `);
                }
            }
        }
    } else {
        console.error("Invalid eventData format.");
    }
}

function createEventTable(participants, houseName, menu,title) {
    const filteredParticipants = participants.filter(participant => participant.student_house === houseName);

    if (filteredParticipants.length > 0) {
        let eventDetails = document.createElement("div");
        eventDetails.className = "event-details";
        eventDetails.innerHTML = `
            <h4 class="title">${title}</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>s.no</th>
                        <th>REGISTER NUMBER</th>
                        <th>STUDENT NAME</th>
                        <th>STUDENT DEPARTMENT</th>
                    </tr>
                </thead>
                <tbody>
                    ${filteredParticipants.map((participant, index) => `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${participant.reg_no}</td>
                            <td>${participant.student_name}</td>
                            <td>${participant.student_dept}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;

        menu.appendChild(eventDetails);
    }
}



function setIndicator(sel) {
	sl = sel;
	let vp = "";
	if (window.innerWidth < 800) {
		vp = "60px";
	} else {
		vp = "85%";
	}
	let elems = [ni1, ni2, ni3, ni4, ni5, ni6, ni7, ni8];
	for (i = 0; i < elems.length; i++) {
		if (i === sel) {
			elems[i].style.width = vp;
			elems[i].style.boxShadow = "2px 2px 10px 2px var(--icolor" + (i + 1) + ")";
		} 
		else {
			elems[i].style.width = "0";
			elems[i].style.boxShadow = "none";
		}
	}
}

window.addEventListener("resize", (e) => {
	setIndicator(sl);
});

//default runs
setIndicator(sl);
