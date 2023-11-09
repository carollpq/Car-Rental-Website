let menu = document.querySelector('#menu-icon');
let navbar = document.querySelector(".navbar");

menu.onclick = () => {
    menu.classList.toggle("bx-x");
    navbar.classList.toggle("active");
}

window.onscroll = () => {
    menu.classList.remove('bx-x');
    navbar.classList.remove("active");
}

// Scroll reveal
const sr = ScrollReveal ({
    distance: '60px',
    duration: 2500,
    delay: 100,
    reset: true
})
//Drop-down menu
const optionMenu = document.querySelector(".select-menu"),
selectBtn = optionMenu.querySelector(".select-btn"),
options = optionMenu.querySelectorAll(".option"),
sBtn_text = optionMenu.querySelector(".sBtn-text");

selectBtn.addEventListener("click", () => optionMenu.classList.toggle("active"));       

options.forEach(option =>{
  option.addEventListener("click", ()=>{
  let selectedOption = option.querySelector(".sub-option-text").innerText;
  sBtn_text.innerText = selectedOption;

  optionMenu.classList.remove("active");
  });
});

let subMenu = document.getElementById("subMenu");
let subForm = document.getElementById("reservation-box");

// sub-menu drop down
function toggleMenu() {
  document.getElementById("subMenu").classList.toggle("open-menu");
}
//Section for drop-down menu ends here

//Validate date
function validateDate(form)
{
  var currentDate = new Date().toISOString().slice(0, 10);
  //Making sure user enters a date / does not enter past dates
  if (form.booked_date.value < currentDate || form.return_date.value < currentDate)
  {
      alert("The Inserted Dates Are Invalid. Please Enter Dates From Today Onwards.");
      return false;
  }
  //If return date < pickup date
  else if (form.booked_date.value > form.return_date.value )
  {
      alert("Invalid Return Date. Return Date Cannot Be Before Pickup Date");
      return false;
  }
  else
  {
    return true;
  }
}

//Form validation
//Validate user registration info
function validateRegistration(form)
{
  fail = validateFirstname(form.firstname.value); //Validate First Name
  fail += validateLastname(form.lastname.value); //Validate Last Name
  fail += validateEmail(form.email.value); //Validate Email address
  fail += validatePhoneNum(form.phone_num.value); //Validate phone number
  fail += validateLocation(form.location.value); //Validate location entered

  if (fail === "") 
  {
      return true;
  }
  else 
  { 
      alert(fail); 
      return false;
  }
}

function validateFirstname(field)
{
  if (field == "") //If nothing was entered
  {
    return "No Firstname was entered.\n";
  }
  else if (/[^a-zA-Z, ]/.test(field)) //If irrelevant characters were entered
  {
    return "Only a-z, A-Z allowed in first names.\n";
  }
  else
  {
    return "";
  }
}

function validateLastname(field)
{
  if (field == "") // If nothing was entered
  {
    return "No Surname was entered.\n";
  }
  else if (/[^a-zA-Z, ]/.test(field)) //If irrelevant characters were entered
  {
    return "Only a-z, A-Z allowed in Surnames.\n";
  }
  else
  {
    return "";
  }
}

function validatePhoneNum(field)
{
  if (field == "") //If nothing was entered
  {
    return "No phone number was entered.\n";
  }
  else if (/[^0-9]/.test(field)) //If irrelevant characters were entered
  {
    return "0-9 are allowed in phone number.\n";
  }
  else
  {
    return "";
  }
}

//Validate email
function validateEmail(field)
{
  if (field == "") //If nothing was entered
  {
    return "No Email was entered.\n";
  }
  else if (!((field.indexOf(".") > 0) && (field.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(field)) //check whether email is valid or not
  {
    return "The Email address is invalid.\n";
  }
  else
  {
    return "";
  }
}

function validateLocation(field)
{
  if (field == "") //If nothing was entered
  {
    return "No Location name was entered.\n";
  }
  else if (field.length < 3)
  {
    return "Location name must be at least 3 characters.\n";
  }
  else if (/[^a-zA-Z0-9., ]/.test(field)) //if there are irrelevant characters
  {
    return "Invalid Location.\n";
  }
  else
  {
    return "";
  }
}
// attempt to validate reservation form ends here