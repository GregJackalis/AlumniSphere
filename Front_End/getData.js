let backRes = [];

async function getData(reqType) {
    try {
        const response = await fetch('Back_End/index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                type: reqType 
            }), // Pass data in the body
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const text = await response.text(); // Get raw response text
        console.log('Raw response:', text);

        
        let parsedResponse = JSON.parse(text);
        backRes = parsedResponse.message;
        console.log(backRes);

        createCards(backRes);

    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}

window.onload = function() {
    getData('card');
 };
 

function createCard(person) {
    const cardDiv = document.createElement('div');
    cardDiv.classList.add('col');

    const card = document.createElement('div');
    card.classList.add('card');

    const img = document.createElement('img');
    img.classList.add('card-img-top');
    img.alt = 'Profile Picture';

    // Event listener for the 'onerror' event
    img.onerror = function(event) {
        event.preventDefault(); // Prevent the default behavior (logging the error)
        img.src = './Front_End/images/default.png'; // Fallback/default image URL
    };

    // Set the src attribute after setting up the onerror handler
    img.src = person.photo; // Assuming person.photo contains the URL of the image

    const cardBody = document.createElement('div');
    cardBody.classList.add('card-body');

    const title = document.createElement('h5');
    title.classList.add('card-title');
    title.textContent = person.name + ' ' + person.surname;

    const school = document.createElement('p');
    school.classList.add('card-title');
    school.textContent = `School of ${person.school}`;

    const about = document.createElement('p');
    about.classList.add('card-text');
    about.textContent = person.about;

    const buttonDiv = document.createElement('div');
    buttonDiv.classList.add('d-flex', 'justify-content-end', 'pe-3', 'pb-3');

    const button = document.createElement('button');
    button.classList.add('btn', 'btn-primary');
    button.textContent = 'See CV';

    button.addEventListener('click', async function(event) {
        event.preventDefault();

        const pdfLocation = person.pdf;

        try {
            const response = await fetch(pdfLocation);
            if (response.ok) {
                window.open(pdfLocation, '_blank');
            } else {
                console.log('CV not available');
                alert(`CV of user ${person.name} ${person.surname} could not be retrieved`);
            }
        } catch (error) {
            console.error('Error checking PDF location:', error);
        }
    });

    buttonDiv.appendChild(button);
    cardBody.appendChild(title);
    cardBody.appendChild(school);
    cardBody.appendChild(about);
    card.appendChild(img);
    card.appendChild(cardBody);
    card.appendChild(buttonDiv);
    cardDiv.appendChild(card);

    return cardDiv;
}

// Function to create cards for each person in backRes
function createCards(data) {
    const cardArea = document.createElement('div');
    cardArea.classList.add('row', 'row-cols-1', 'row-cols-md-3', 'g-4', 'py-5');

    data.forEach(person => {
        const card = createCard(person);
        cardArea.appendChild(card);
    });

    // Append the container to the document body or any other desired parent element
    const container = document.getElementById('card-container');
    container.appendChild(cardArea);

}

const artsBtn = document.querySelector('#artsBtn');

artsBtn.addEventListener('click', function () {
    filtering('Arts & Design'); // Assuming 'Arts & Design' is the type of school for the arts button
});

const businessBtn = document.querySelector('#businessBtn');

businessBtn.addEventListener('click', function () {
    filtering('Business'); // Assuming 'Arts & Design' is the type of school for the arts button
});

const computingBtn = document.querySelector('#computingBtn');

computingBtn.addEventListener('click', function () {
    filtering('Computing'); // Assuming 'Arts & Design' is the type of school for the arts button
});

const educationBtn = document.querySelector('#educationBtn');

educationBtn.addEventListener('click', function () {
    filtering('Education'); // Assuming 'Arts & Design' is the type of school for the arts button
});

const engineeringBtn = document.querySelector('#engineeringBtn');

engineeringBtn.addEventListener('click', function () {
    filtering('Engineering'); // Assuming 'Arts & Design' is the type of school for the arts button
});

const healthSportBtn = document.querySelector('#healthSportBtn');

healthSportBtn.addEventListener('click', function () {
    filtering('Health & Sport Sciences'); // Assuming 'Arts & Design' is the type of school for the arts button
});

const psychologyBtn = document.querySelector('#psychologyBtn');

psychologyBtn.addEventListener('click', function () {
    filtering('Psychology'); // Assuming 'Arts & Design' is the type of school for the arts button
});

const shippingBtn = document.querySelector('#shippingBtn');

shippingBtn.addEventListener('click', function () {
    filtering('Shipping'); // Assuming 'Arts & Design' is the type of school for the arts button
});

const tourismBtn = document.querySelector('#tourismBtn');

tourismBtn.addEventListener('click', function () {
    filtering('Tourism & Hospitality'); // Assuming 'Arts & Design' is the type of school for the arts button
});

const showAllBtn = document.querySelector('#showAllBtn');

showAllBtn.addEventListener('click', function () {
    filtering('showAll'); // Assuming 'Arts & Design' is the type of school for the arts button
});

function filtering(typeOfBtn) {
    let filteredData = [];
    if (typeOfBtn === "showAll") {
        filteredData = backRes;
    } else {
        filteredData = backRes.filter(person => {
            return person.school === typeOfBtn; // Filter persons whose school matches the selected type
        });
    }

    // Remove existing cards from the container
    const container = document.getElementById('card-container');
    container.innerHTML = '';

    // Create and append new cards for the filtered data
    createCards(filteredData);
}

// }