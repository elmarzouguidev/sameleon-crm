<script>
    function getChecked(checkboxName) {
        let checkBoxes = document.getElementsByName(checkboxName);
        let ids = Array.prototype.slice.call(checkBoxes)
            .filter(ch => ch.checked == true)
            .map(ch => ch.value);
        return ids;
    }

    function getSelected() {
        let client = $('#clientsList').select2('data');
        console.log(client[0].id);
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

        let clientId = getSelected();

        let statusId = getStatus();

        let comanyIds = getChecked("company");

        let sendId = getChecked("send");

        let getDate = getDateFilter();

        // console.log(clientId);

        let href = '{{ collect(request()->segments())->last() }}?';

        if (comanyIds.length) {
            href += 'appFilter[GetCompany]=' + comanyIds;
        }

        if (statusId.length) {
            href += '&appFilter[GetStatus]=' + statusId;
        }
        if (clientId.length) {
            href += '&appFilter[GetClient]=' + clientId;
        }
        if (sendId.length) {
            href += '&appFilter[GetSend]=' + sendId;
        }
        if (getDate.length) {
            href += '&appFilter[GetEstimateDate]=' + getDate;
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
