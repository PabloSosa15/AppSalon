let step = 1;
const stepInitial = 1;
const stepFinal = 3;

const appointment = {
    id: '',
    name:'',
    date: '',
    hour: '',
    services: []
    }

document.addEventListener('DOMContentLoaded', function () {
    startApp();
});

function startApp() {
    showSection(); // Show and hide sections
    tabs(); // Change section, when tabs are pressed
    buttonsPager(); // Add or remove the buttons from the pager
    nextPage();
    previousPage();

    queryApi(); // Query the API in PHP backend

    idClient()
    clientName(); // Add the client's to the object
    selectDate(); // Add the appointment date to the object
    selectHour(); // Add the appointment hour to the object

    showPreview(); // Show the previer appointment
}

function showSection() {
    //Hide the section that has the show clas
    const sectionPrevious = document.querySelector('.show');
    if (sectionPrevious) {
        sectionPrevious.classList.remove('show');
    }
    //Select the section with the step
    const section = document.querySelector(`#step-${step}`);
    section.classList.add('show');
    //Removes the current class from the previous tab
    const tabPrevious = document.querySelector('.current');
    if (tabPrevious) {
        tabPrevious.classList.remove('current');
    }
    //Highlights the current tab
    const tab = document.querySelector(`[data-step="${step}"]`);
    tab.classList.add('current');

}

function tabs() {
    const buttons = document.querySelectorAll('.tabs button');
    buttons.forEach( button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            step = parseInt(e.target.dataset.step);
            showSection();
            
            buttonsPager();

        });
    })


}

function buttonsPager() {
    const previousPage = document.querySelector('#previous');
    const nextPage = document.querySelector('#next');

    if (step === 1) {
        previousPage.classList.add('hide');
    } else if (step === 3) {
        previousPage.classList.remove('hide');
        nextPage.classList.add('hide');

        showPreview();
    } else {
        previousPage.classList.remove('hide');
        nextPage.classList.remove('hide');
    }
    showSection();
}

function previousPage() { 
    const previousPage = document.querySelector('#previous');
    previousPage.addEventListener('click', function () {
        if (step <= stepInitial) return;
        step--;
        buttonsPager();
    });
};

function nextPage() { 
    const nextPage = document.querySelector('#next');
    nextPage.addEventListener('click', function () {
        if (step >= stepFinal) return;
        step++;
        buttonsPager();
    })
};

async function queryApi() {
    try {
        const url = `${location.origin}/api/services`;
        const result = await fetch(url);
        const services = await result.json();
        console.log(services);
        showServices(services);

    } catch (fix) {
        console.log(fix);
    }
}

function showServices(services) {
    services.forEach(service => {
        const { id, name, price } = service;

        const nameService = document.createElement('P');
        nameService.classList.add('name-service');
        nameService.textContent = name;

        const priceService = document.createElement('P');
        priceService.classList.add('price-service');
        priceService.textContent = `$${price}`;

        const serviceDiv = document.createElement('DIV');
        serviceDiv.classList.add('service');
        serviceDiv.dataset.idService = id;
        serviceDiv.onclick = function () {
            selectServices(service);
        };

        serviceDiv.appendChild(nameService);
        serviceDiv.appendChild(priceService);

        document.querySelector('#services').appendChild(serviceDiv);
    });
}

function selectServices(service) {
    const { id } = service;
    const { services } = appointment;

    //Identify the clicked element
    const divService = document.querySelector(`[data-id-service="${id}"]`);

    // Check if a service has already been added
    if (services.some(added => added.id === id)) {
        //Delete it
        appointment.services = services.filter(added => added.id !== id);
        divService.classList.remove('selected');
    } else {
        //Add it
        appointment.services = [...services, service];
        divService.classList.add('selected');
    }

}
function idClient() {
    appointment.id = document.querySelector('#id').value;
}

function clientName() {
    appointment.name = document.querySelector('#name').value;
}

function selectDate() {
    const inputDate = document.querySelector('#date');
    inputDate.addEventListener('input', function (e) {

        const day = new Date(e.target.value).getUTCDay();
        
        if ([5, 6].includes(day)) {
            e.target.value = '';
            showAlert('Friday and Saturday we do not work', 'fix', '.formulary');
        } else {
            appointment.date = e.target.value;
        }
    });
}

function selectHour() {
    const inputHour = document.querySelector('#hour');
    inputHour.addEventListener('input', function (e) {
        const hourAppointment = e.target.value;
        const hour = hourAppointment.split(":")[0];
        if (hour < 10 || hour > 18) {
            e.target.value = '';
            showAlert('Invalid Time', 'fix', '.formulary');
        } else {
            appointment.hour = e.target.value;

            console.log(appointment);
        }
    });
}

function showAlert(message, type, element, disappears = true) {

    //Prevents more than one alert from being generated.
    const previewAlert = document.querySelector('.alert');
    if (previewAlert) {
        previewAlert.remove();
    };
    
    //Scripting to create an alert
    const alert = document.createElement('DIV');
    alert.textContent = message;
    alert.classList.add('alert');
    alert.classList.add(type);
 
    const reference = document.querySelector(element);
    reference.appendChild(alert);

    if (disappears) {
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
    }


function showPreview() { 
    const preview = document.querySelector('.content-preview');

    //Clear the contents of the summary
    while (preview.firstChild) {
        preview.removeChild(preview.firstChild);
    }
    
    if (Object.values(appointment).includes('') || appointment.services.length === 0 ) {
        showAlert('Missing Service data, Date or Time', 'fix', '.content-preview', false);

        return;
    }

    //Formatting the summary div
    const { name, date, hour, services } = appointment;


    //Heading for service in preview
    const headingServices = document.createElement('H3');
    headingServices.textContent = 'Services Preview';
    preview.appendChild(headingServices);

    //Iterating and displaying services
    services.forEach(service => {
        const { id, price, name } = service;
        const containerService = document.createElement('DIV');
        containerService.classList.add('container-service');

        const textService = document.createElement('P');
        textService.textContent = name;

        const priceService = document.createElement('P');
        priceService.innerHTML = `<span>Price:</span> $${price}`;
        containerService.appendChild(textService);
        containerService.appendChild(priceService);

        preview.appendChild(containerService);
    });

    //Heading for service in preview
    const headingAppointment = document.createElement('H3');
    headingAppointment.textContent = 'Appointment Preview';
    preview.appendChild(headingAppointment);

    //Format the date in English
    const dateObj = new Date(date);
    const month = dateObj.getMonth();
    const day = dateObj.getDay() + 2;
    const year = dateObj.getFullYear();
    
    const dateUTC = new Date(Date.UTC(year, month, day));
    
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
    const dateFormatted = dateUTC.toLocaleDateString('en-US', options);


    const appointmentDate = document.createElement('P');
    appointmentDate.innerHTML = `<span>Date:</span> ${dateFormatted}`;

    const appointmentHour = document.createElement('P');
    appointmentHour.innerHTML = `<span>Hour:</span> ${hour} Hours`;

        
    const nameClient = document.createElement('P');
    nameClient.innerHTML = `<span>Name:</span> ${name}`;

    //Button for create date

    const bookButton = document.createElement('BUTTON');
    bookButton.classList.add('button');
    bookButton.textContent = 'Book';
    bookButton.onclick = bookDate;
    

    preview.appendChild(nameClient);
    preview.appendChild(appointmentDate);
    preview.appendChild(appointmentHour);
    
    preview.appendChild(bookButton);
}

async function bookDate() {
    const { name, date, hour, services, id } = appointment;

    const idService = services.map( service => service.id );

    const dates = new FormData();

    dates.append('date', date);
    dates.append('hour', hour);
    dates.append('userId', id);
    dates.append('services', idService);


    try {
        
    //Request to the API
    const url = `${location.origin}/api/appointments`
    const answer = await fetch(url, {
        method: 'POST',
        body: dates
    });
        
        const result = await answer.json();
        console.log(result);

        if (result.result) {
            Swal.fire({
                icon: 'success',
                title: 'appointment created',
                text: 'Your appointment was successfully created',
                button: 'OK'
            }).then(() => {
                    window.location.reload();
              })
        }  
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'There was an error saving the appointment!'
          })
    }

}

