var emailValue = document.getElementById('email');
var commentValue = document.getElementById('comment');
var toRespondValue = document.getElementById('toRespond');

function send(event){
  //console.log("TOKEN: "+event);

   // event.preventDefault();

    let formValues = document.getElementById('formId');
    let formData = new FormData(formValues);

   // console.log(emailValue.value, commentValue.value,toRespondValue.value);

    formData.append('email',emailValue.value);
    formData.append('comment',commentValue.value);
    formData.append('torespond',toRespondValue.value);

    formData.forEach(value => console.log(value));
    

    var object = {};
    
    formData.forEach((value, key) => object[key] = value);

    //validation

    if(ValidateEmail(emailValue)){
        //if valid->fetch
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
    }else{
        alert("Invalid email address!");
        document.getElementById("formId").reset();
    }
    
   
}
function ValidateEmail(email){
    
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    if (email.value.match(validRegex)) {      
        return true;
    } else {  
        return false;
    }
}

