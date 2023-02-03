el = document.getElementById("js_btn");

el.addEventListener('click', (event) => {event.preventDefault(); fetchMovies()});


async function fetchMovies() {
    name_person = document.getElementById("name_person").value;
    email_person = document.getElementById("email_person").value;
    link_person = document.getElementById("link_person").value;

    
    data = {name: name_person,
            email: email_person,
            link: link_person};
    
    const response = await fetch('/send', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });        
    console.log(response);
    alert('Success');
    document.getElementById("name_person").value = "";
    document.getElementById("email_person").value = "";
    document.getElementById("link_person").value = "";
    
  }
  