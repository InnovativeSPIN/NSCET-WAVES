function populateItems(eventData, houseName) {
    let menu = document.querySelector(".menu");
    menu.innerHTML = "";

    if (eventData.event) {
        const event = eventData.event;

        if (event.is_group === "0") {
            createEventTable(eventData.participants, houseName, menu, 'Event Details');
        } else if (event.is_group === "1") {
            const groups = eventData.groups;
            for (const group of groups) {
                if (group.participants && group.participants.length > 0) {
                    createEventTable(group.participants, houseName, menu, `Group ${group.group_number} Details`);
                }
            }
        }
    } else {
        console.error("Invalid eventData format.");
    }
}

function createEventTable(participants, houseName, menu, title) {
    const filteredParticipants = participants.filter(participant => participant.student_house === houseName);

    if (filteredParticipants.length > 0) {
        let eventDetails = document.createElement("div");
        eventDetails.className = "event-details mb-4";
        eventDetails.innerHTML = `
            <h4 class="title mb-3" style="color: var(--accent-pink);">${title}</h4>
            <div class="table-responsive">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>S.NO</th>
                            <th>REGISTER NUMBER</th>
                            <th>STUDENT NAME</th>
                            <th>STUDENT DEPARTMENT</th>
                            <th>SLOT NUMBER</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${filteredParticipants.map((participant, index) => `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${participant.reg_no}</td>
                                <td>${participant.student_name}</td>
                                <td>${participant.student_dept}</td>
                                <td>${participant.slot || '-'}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>`;

        menu.appendChild(eventDetails);
    } else {
        menu.innerHTML += `<div class="text-center text-muted my-4">No participants found for ${title}.</div>`;
    }
}

function setActive(btn) {
    // Remove active class from all pills
    document.querySelectorAll('.house-pill').forEach(el => el.classList.remove('active'));
    // Add active class to clicked pill
    btn.classList.add('active');
}
