<div id="listDiv"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    loadList();
 
    function loadList() {
        $.ajax({
            url:'Expense_person/getList',
            method: 'post'
        }).done(function(returnedData) {
            $('#listDiv').html(returnedData.html);
        })
    }
</script>