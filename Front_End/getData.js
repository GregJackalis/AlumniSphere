let backRes = [];
// let btnIdentifier = 0;
let loggedIn = false;

async function getData(reqType) {
   try {
       const response = await fetch('Back_End/index.php', {
           method: 'POST',
           headers: {
               'Content-Type': 'application/json'
           },
           body: JSON.stringify({ 
               type: reqType 
           }),
       });

       if (!response.ok) {
           throw new Error('Network response was not ok');
       }

       const text = await response.text();
       // console.log('Raw response:', text);

       let parsedResponse = JSON.parse(text);
       backRes = parsedResponse.message;
       // console.log(backRes);

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

   img.onerror = function(event) {
       event.preventDefault();
       img.src = './Front_End/images/default.png';
   };

   img.src = "./Front_End/" + person.photo;

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

   if (loggedIn == false) {
       button.style.display = 'none';
   }

   button.textContent = 'See CV';

   button.addEventListener('click', async function(event) {
       event.preventDefault();

       const pdfLocation = "./Front_End/" + person.pdf;

       try {
           const response = await fetch(pdfLocation);
           if (response.ok) {
               window.open(pdfLocation, '_blank');
           } else {
               // console.log('CV not available');
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

function createCards(data) {
   const cardArea = document.createElement('div');
   cardArea.classList.add('row', 'row-cols-1', 'row-cols-md-3', 'g-4', 'py-5');

   data.forEach(person => {
       const card = createCard(person);
       cardArea.appendChild(card);
   });

   const container = document.getElementById('card-container');
   container.appendChild(cardArea);

}


document.addEventListener('DOMContentLoaded', function () {
   const artsBtn = document.querySelector('#artsBtn');
   artsBtn.addEventListener('click', function () {
       filtering('Arts and Design');
   });

   const businessBtn = document.querySelector('#businessBtn');
   businessBtn.addEventListener('click', function () {
       filtering('Business');
   });

   const computingBtn = document.querySelector('#computingBtn');
   computingBtn.addEventListener('click', function () {
       filtering('Computing');
   });

   const educationBtn = document.querySelector('#educationBtn');
   educationBtn.addEventListener('click', function () {
       filtering('Education');
   });

   const engineeringBtn = document.querySelector('#engineeringBtn');
   engineeringBtn.addEventListener('click', function () {
       filtering('Engineering');
   });

   const healthSportBtn = document.querySelector('#healthSportBtn');
   healthSportBtn.addEventListener('click', function () {
       filtering('Health and Sport Sciences');
   });

   const psychologyBtn = document.querySelector('#psychologyBtn');
   psychologyBtn.addEventListener('click', function () {
       filtering('Psychology');
   });

   const shippingBtn = document.querySelector('#shippingBtn');
   shippingBtn.addEventListener('click', function () {
       filtering('Shipping');
   });

   const tourismBtn = document.querySelector('#tourismBtn');
   tourismBtn.addEventListener('click', function () {
       filtering('Tourism and Hospitality');
   });

   const showAllBtn = document.querySelector('#showAllBtn');
   showAllBtn.addEventListener('click', function () {
       filtering('showAll');
   });

   function filtering(typeOfBtn) {
       let filteredData = [];
       // console.log(typeOfBtn);
       if (typeOfBtn === "showAll") {
           filteredData = backRes;
       } else {
           filteredData = backRes.filter(person => {
               return person.school === typeOfBtn;
           });
       }

       const container = document.getElementById('card-container');
       container.innerHTML = '';

       createCards(filteredData);
   }
});


function setLoggedIn() {
   // console.log("IM HERE");
   loggedIn = true;
   // console.log(loggedIn);

}
