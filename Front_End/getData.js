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
        //console.log('Raw response:', text);

        
        let parsedResponse = JSON.parse(text);
        let backRes = parsedResponse.message;
        //console.log(backRes);

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
    img.src = person.photo; // Default image URL

    // img.src = './Front_End/images/person1.jpeg'; // Default image URL
    img.alt = 'Profile Picture';

    // Event listener for the 'onerror' event
    img.onerror = function() {
        img.src = './Front_End/images/default.png'; // Backup image URL
    };

    // Set the src attribute after setting up the onerror handler
    img.src = "./Front_End/" + person.photo; // Assuming person.photo contains the URL of the image
    
    console.log("./Front_End/" + person.photo);

    const cardBody = document.createElement('div');
    cardBody.classList.add('card-body');

    const title = document.createElement('h5');
    title.classList.add('card-title');
    title.textContent = person.name + ' ' + person.surname;

    const school = document.createElement('h5');
    school.classList.add('card-title');
    school.textContent = `School: ${person.school}`;

    // FOR EMAIL: `Email: ${person.email}\n

    const about = document.createElement('p');
    about.classList.add('card-text');
    // about.style.marginTop = '-50px';
    about.textContent = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";
    

    const buttonDiv = document.createElement('div');
    buttonDiv.classList.add('d-flex', 'justify-content-end', 'pe-3', 'pb-3');

    const button = document.createElement('button');
    button.classList.add('btn', 'btn-primary');
    button.textContent = 'See CV';
    button.addEventListener('click', function() {
        // console.log(person.pdf);
        if ("./Front_End/"+person.pdf) {
            window.open("./Front_End/"+person.pdf, '_blank');
        } else {
            console.log('CV not available');
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
function createCards(backRes) {
    const cardArea = document.createElement('div');
    cardArea.classList.add('row', 'row-cols-1', 'row-cols-md-3', 'g-4', 'py-5');

    backRes.forEach(person => {
        const card = createCard(person);
        cardArea.appendChild(card);
    });

    // Append the container to the document body or any other desired parent element
    const container = document.getElementById('card-container');
    container.appendChild(cardArea);
}