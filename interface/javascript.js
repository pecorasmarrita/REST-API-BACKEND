var lastEmployeeID=0;

function getridof(r)
{
	deleteEmployee(r);
	location.reload();
}

function edit(r)
{
	showForm("edit", r);
}

function checkboxselect(checkbox) {
    let elementsArr = document.getElementsByName('checkbox');
    for (let i = 0; i < elementsArr.length; i++) elementsArr[i].checked = checkbox.checked;
}

function addbutton() {
	showForm("add", 0);
}

function deletebutton() {
    $('input:checked').each(function(index) {
		if (!(index==0&&document.getElementById("checkbox").checked))
		{
			let idvar = $(this).attr('id');
			console.log(idvar);
			deleteEmployee(idvar);
		}
    });
	location.reload();
}

function showForm(tipo, id)
{
	var form = document.createElement("form");
	let titolo = document.createElement("h3");
	let azione = "";
	if (tipo == "add")
	{
		titolo.innerHTML='<h3 class="forminserimento">Aggiungi impiegato</h3>';
		azione = 'onclick="addEmployee()">Aggiungi';
	}
	else
	{
		titolo.innerHTML='<h3 class="forminserimento">Modifica impiegato</h3>';
		azione = 'onclick="editEmployee('+id+')">Modifica';
	}
	form.innerHTML='<br>\
  <div class="form-group forminserimento">\
    <label class="forminserimento" for="nameinput">Nome</label>\
    <input type="text" class="form-control" id="nameinput" placeholder="Inserire nome impiegato">\
	<label class="forminserimento" for="surnameinput">Cognome</label>\
    <input type="text" class="form-control" id="surnameinput" placeholder="Inserire cognome impiegato">\
	<label for="emailinput">Email</label>\
    <input type="email" class="form-control" id="emailinput" placeholder="Inserire email impiegato">\
	<label for="phoneinput">Phone</label>\
    <input type="phone" class="form-control" id="phoneinput" placeholder="Inserire telefono impiegato">\
  </div>\
  <div class="form-group forminserimento"><br>\
  <button class="btn btn-secondary colspan6" onclick="location.reload()">Annulla</button>\
  <button class="btn btn-primary colspan6"'+azione+'</button>\
  </div>\
  ';
document.body.appendChild(titolo);
document.body.appendChild(form);
}

function addEmployee()
{
	lastEmployeeID++;
	var JSONEmployee = 
	{
	"employeeId": lastEmployeeID,
    "firstName": $('#nameinput').val(),
    "lastName": $('#surnameinput').val(),
    "email": $('#emailinput').val(),
    "phone": $('#phoneinput').val()
    };
	console.log(JSONEmployee);
	$.ajax({
	url: 'http://localhost/rest/tutorial/1.0/employees/',
	type: 'post',
	data : JSON.stringify(JSONEmployee),
	contentType: 'application/json',
	success: function (data,textstatus,jQxhr)
		{
		location.reload();
		}
	});
}

function editEmployee(id)
{
	var JSONEmployee =
	{
	"employeeId": id,
    "firstName": $('#nameinput').val(),
    "lastName": $('#surnameinput').val(),
    "email": $('#emailinput').val(),
    "phone": $('#phoneinput').val()
    };
	console.log(JSONEmployee);
	$.ajax({
	url: 'http://localhost/rest/tutorial/1.0/employees/'+id,
	type: 'put',
	data : JSON.stringify(JSONEmployee),
	contentType: 'application/json',
	success: function (data,textstatus,jQxhr)
		{
		location.reload();
		}
	});
}

function deleteEmployee(id)
{
	$.ajax({
	url: "http://localhost/rest/tutorial/1.0/employees/"+id,
    type: "delete",
    contentType: 'String',
    success: function (data,textstatus,jQxhr){
    
    }
     });
}

$(document).ready(function() {
    $.ajax({
	url: 'http://localhost/rest/student.php',
    type: 'get',
    contentType: 'application/json',
    
	success: function(data, textstatus, jQxhr){  
	console.log(data);
    let dataDefault = data;
    let html = '';
    $.each(data, function(key, value){
		html += '<tr>';
        html += '<td><input class="form-check-input" type="checkbox" name="checkbox" id="'+value.id+'"></td>';
        html += '<td><p>'+value.name+' '+value.surname+'</p></td>'+'<td><p>'+value.sidi_code+'</p></td>'+'<td><p></p></td>'+'<td><p>'+value.tax_code+'</p></td>';
        html += '<td><button class="btn btn"><img onClick="edit('+value.id+')" class="buttonscss" src="img/editbutton.png"></button></td>';
        html += '<td><button class="btn btn"><img onClick="getridof('+value.id+')" class="buttonscss" src="img/removebutton.png"></button></td>';
        html += '<tr>';
		lastEmployeeID = value.id;
        });
    $('#manage_table').append(html);
      },
	error: function(jQxhr, textstatus, errorThrown){
		console.log(errorThrown);
	}
    });
});
