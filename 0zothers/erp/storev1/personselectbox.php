<?php



$role = $_SESSION['SESSION_ROLE'];

$query = "
  SELECT * FROM select_boxp where role='$role'
ORDER BY select_box_name ASC
";

$result = $connect->query($query);

?>





<?php
foreach ($result as $row) {
  echo '<option value="' . $row['select_box_name'] . '">' . $row['select_box_name'] . '</option>';
}
?>




<script>

  $(document).ready(function () {

    $('.select2p').select2({
      placeholder: 'Select/Add New',
      theme: 'bootstrap4',
      tags: true,
    }).on('select2:close', function () {
      var element = $(this);
      var new_select_box = $.trim(element.val());

      if (new_select_box != '') {
        $.ajax({
          url: "personselectboxadd.php",
          method: "POST",
          data: { select_box_name: new_select_box },
          success: function (data) {
            if (data == 'yes') {
              element.append('<option value="' + new_select_box + '">' + new_select_box + '</option>').val(new_select_box);
            }
          }
        })
      }

    });

  });

</script>