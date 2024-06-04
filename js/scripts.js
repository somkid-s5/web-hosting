/*!
 * Start Bootstrap - New Age v6.0.7 (https://startbootstrap.com/theme/new-age)
 * Copyright 2013-2023 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-new-age/blob/master/LICENSE)
 */
//
// Scripts
//

window.addEventListener("DOMContentLoaded", (event) => {
  // Activate Bootstrap scrollspy on the main nav element
  const mainNav = document.body.querySelector("#mainNav");
  if (mainNav) {
    new bootstrap.ScrollSpy(document.body, {
      target: "#mainNav",
      offset: 74,
    });
  }

  // Collapse responsive navbar when toggler is visible
  const navbarToggler = document.body.querySelector(".navbar-toggler");
  const responsiveNavItems = [].slice.call(
    document.querySelectorAll("#navbarResponsive .nav-link")
  );
  responsiveNavItems.map(function (responsiveNavItem) {
    responsiveNavItem.addEventListener("click", () => {
      if (window.getComputedStyle(navbarToggler).display !== "none") {
        navbarToggler.click();
      }
    });
  });
   // Toggle the side navigation
   const sidebarToggle = document.body.querySelector('#sidebarToggle');
   if (sidebarToggle) {
       // Uncomment Below to persist sidebar toggle between refreshes
       // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
       //     document.body.classList.toggle('sb-sidenav-toggled');
       // }
       sidebarToggle.addEventListener('click', event => {
           event.preventDefault();
           document.body.classList.toggle('sb-sidenav-toggled');
           localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
       });
   }
});







// JavaScript สำหรับกำหนดค่าในฟอร์มใน Modal เมื่อคลิกที่ปุ่ม "แก้ไข" ในตาราง
function openEditModal(id, name) {
  document.getElementById("id").value = id;
  document.getElementById("name").value = name;
  $("#editModal").modal("toggle");
}

function openRenewalModal(service_id, domain, date) {
  document.getElementById("service_id").value = service_id;
  document.getElementById("domain").textContent =  domain + ' วันหมดอายุ: ' + date;
  $("#renewalModal").modal("toggle");
}








// sweet-alert.js
function showSuccessAlert(massage) {
  Swal.fire({
    title: "Success",
    text: massage,
    icon: "success",
    timer: 5000,
    showConfirmButton: false,
  });
}

function showWarningAlert(massage) {
  Swal.fire({
    title: "Warning",
    text: massage,
    icon: "warning",
    timer: 5000,
    showConfirmButton: false,
  });
}

function showErrorAlert(massage) {
  Swal.fire({
    title: "Error",
    text: massage,
    icon: "error",
    timer: 5000,
    showConfirmButton: false,
  });
}

function autoclose() {
  let timerInterval;
  Swal.fire({
    title: "Auto close alert!",
    html: "I will close in <b></b> milliseconds.",
    timer: 2000,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
      const b = Swal.getHtmlContainer().querySelector("b");
      timerInterval = setInterval(() => {
        b.textContent = Swal.getTimerLeft();
      }, 100);
    },
    willClose: () => {
      clearInterval(timerInterval);
    },
  }).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
      console.log("I was closed by the timer");
    }
  });
}



/* global bootstrap: false */
(() => {
  'use strict'
  const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.forEach(tooltipTriggerEl => {
    new bootstrap.Tooltip(tooltipTriggerEl)
  })
})()



function openTable(evt, tableName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tableName).style.display = "block";
    evt.currentTarget.className += " active";
}


// document.getElementById("defaultOpen").click();

function changeHeading(status) {
  document.getElementById("dynamic-heading").textContent = "List of Service " + status;
}
function changeHeading2(status) {
  document.getElementById("dynamic-heading2").textContent = "List of Renewal " + status;
}


// ฟังก์ชันเพื่อกำหนดค่าเริ่มต้น
function setDefaultForm() {
  document.getElementById('subdomainSection').style.display = 'block';
  document.getElementById('domainNameSection').style.display = 'none';
  document.getElementsByName('domain_name')[0].value = ' '; // ล้างค่าฟิลด์ Domain Name
}

// เรียกฟังก์ชันค่าเริ่มต้นเมื่อโหลดหน้าหรือเมื่อมีการเปลี่ยนแปลงใน radio buttons
setDefaultForm();

document.querySelectorAll('input[type="radio"]').forEach(function (radio) {
  radio.addEventListener('change', function () {
      if (radio.id === 'Radio1' && radio.checked) {
          // ถ้าติกที่ option1 ให้แสดง Subdomain และซ่อน Domain Name
          document.getElementById('subdomainSection').style.display = 'block';
          document.getElementById('domainNameSection').style.display = 'none';
          document.getElementsByName('subdomain')[0].value = '';
          document.getElementsByName('domain_name')[0].value = ' '; // ล้างค่าฟิลด์ Domain Name
      } else if (radio.id === 'Radio2' && radio.checked) {
          // ถ้าติกที่ option2 ให้แสดง Domain Name และซ่อน Subdomain
          document.getElementById('subdomainSection').style.display = 'none';
          document.getElementById('domainNameSection').style.display = 'block';
          document.getElementsByName('domain_name')[0].value = '';
          document.getElementsByName('subdomain')[0].value = ' '; // ล้างค่าฟิลด์ Subdomain
      }
  });
});


