<script>
document.getElementById('add_btn').addEventListener('click', e => {
    var addForm = document.getElementById('add_form').style.display = "block"
    document.getElementById('edit_form').style.display = "none";
    document.getElementById('board').style.display = "none";
})
document.getElementById('close_addform').addEventListener('click', e => {
    var addForm = document.getElementById('add_form').style.display = "none"
})
document.getElementById('close_editform').addEventListener('click', e => {
    document.getElementById('edit_form').style.display = "none"
})
document.getElementById('close_card').addEventListener('click', e => {
    document.getElementById('board').style.display = "none";
})



function edit(edit) {
    var admin_id = edit.id;
    document.getElementById('hidden_input').value = admin_id;
    document.getElementById('edit_form').style.display = "block";
    document.getElementById('add_form').style.display = "none"
    document.getElementById('board').style.display = "none";

    var edit = new XMLHttpRequest();


    var url = "ajax/ajax_admin_edit.php";
    var vars = "adminid=" + admin_id;

    edit.open("POST", url, true);



    edit.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    edit.onreadystatechange = function() {
        if (edit.readyState == 4 && edit.status == 200) {
            var data = edit.responseText;
            console.log(data);
            document.getElementById('show_input').innerHTML = data;

        }
    }

    edit.send(vars);

}



function view(view) {
    var adminview_id = view.id;
    document.getElementById('view_input').value = adminview_id;
    document.getElementById('board').style.display = "block";
    document.getElementById('add_form').style.display = "none"
    document.getElementById('edit_form').style.display = "none";

    var xml = new XMLHttpRequest();


    var url = "ajax/senddata.php";
    var id = document.getElementById('view_input').value;

    var vars = "adminid=" + id;

    xml.open("POST", url, true);



    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.onreadystatechange = function() {
        if (xml.readyState == 4 && xml.status == 200) {
            var data = xml.responseText;
            console.log(data);
            document.getElementById('status').innerHTML = data;

        }
    }

    xml.send(vars);

}
</script>
</body>

</html>