<script>
    function getChecked(checkboxName) {
        let checkBoxes = document.getElementsByName(checkboxName);
        let ids = Array.prototype.slice.call(checkBoxes)
            .filter(ch => ch.checked == true)
            .map(ch => ch.value);
        return ids;
    }

    function getSelected() {
        let client = $('#clienter').select2('data');
        // console.log(client[0].id);
        return client[0].id;
    }

    function getStatus() {
        let status = document.getElementById("statusList");
         console.log(status.value);
        return status.value;
    }

    function getDateFilter() {
        let status = document.getElementById("filterDate");
        console.log(status.value);
        return status.value;
    }
    
    function filterResults() {


        let statusIds = getStatus();

        let clientId = getSelected();

        let getDate = getDateFilter();
        // console.log(clientId);

        let href = '{{ collect(request()->segments())->last() }}?';

        if (statusIds.length) {
            href += '&appFilter[GetStatus]=' + statusIds;
        }
        if (clientId.length) {
            href += '&appFilter[GetClient]=' + clientId;
        }
        if (getDate.length) {
            href += '&appFilter[GetInvoiceDate]=' + getDate;
        }
        document.location.href = href;
       // return href;
    }

    document.getElementById("filterData").addEventListener("click", function(event) {

        event.preventDefault();
        filterResults();

        /*$.ajax({
            url: filterResults(),
            type: 'GET',
            success: function() {
                console.log("it Works");
                $("#invoices_lister").load(window.location.href + " #invoices_lister");
            }
        });*/
    });

    /*$(".chk-filter").on("click", function() {
        if (this.checked) {
           // $('#filter').click();
            filterResults()
        }
    });*/
</script>
