var emailValue = document.getElementById('email');
console.log(emailValue);

function send(event){

     event.preventDefault();
     
    var formData = new FormData(event.target);
    
    var object = {};
    
    formData.forEach((value, key) => object[key] = value);
       
    //validācija
    ValidateEmail(emailValue);


    fetch('api/submit.php', {
        method: 'POST', // or 'PUT'
        headers: 
            {
            'Content-Type': 'application/json',
            },
        body: JSON.stringify(object),
    })
  
    .then(data => {
        console.log('Success:', data);
        alert("Data is successfully sent!");
        
        

    })
    .catch((error) => {
    console.error('Error:', error);
    });

    //clear form after submit
    document.getElementById("formId").reset();
   
}
function ValidateEmail(email){

    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    if (email.value.match(validRegex)) {
      
        alert("Valid email address!");
        document.form1.text1.focus();
        return true;
  
    } else {

        alert("Invalid email address!");  
        document.form1.text1.focus(); 
        return false;
    }
}

