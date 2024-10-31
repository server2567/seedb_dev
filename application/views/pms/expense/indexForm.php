<div id="listDiv2"></div>
<input hidden type="text" id="type" value="<?= $type ?>">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    loadList();
    function loadList() {
        $.ajax({
            url:'../editIncome/'+$('#type').val(),
            method: 'post'
        }).done(function(returnedData) {
            $('#listDiv2').html(returnedData.html);
        })
    }
</script>