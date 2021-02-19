var emailValue = document.getElementById('email');
var commentValue = document.getElementById('comment');
var toRespondValue = document.getElementById('toRespond');

function send(event){

   var object = {};

    object['email'] = emailValue.value;
    object['comment'] = commentValue.value;
    object['torespond'] = toRespondValue.value;
    object['token'] = event;

    var com4Validation = commentValue.value;
   // console.log(commentValue.value);
    //validation

    if(ValidateFields(emailValue,com4Validation)){
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
        alert("Invalid email address or empty comment");
        
        //document.getElementById("formId").reset(); --- Nav nepieciešams notirit formu pec nekorekta ievada
    }
    
   
}
function ValidateFields(email, comment){
    
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;


    if (email.value.match(validRegex) && comment != "") {      
        return true;
    } else {  
        return false;
    }
}

