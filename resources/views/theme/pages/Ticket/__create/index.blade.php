@extends('theme.layouts.app')

@section('content')

<div class="container-fluid">

    @include('theme.pages.Ticket.section_0_page_title')

    @include('theme.pages.Ticket.__create.form')

    @include('theme.pages.Ticket.__create.__create_client_modal')

</div>

@endsection

@section('css')

   {{--<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" />
   <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/dropzone/min/dropzone.min.css')}}" />--}}
   <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@once

    @push('scripts')

      <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

      <script src="{{asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
      <script src="{{asset('js/pages/ticket-create.init.js')}}"></script>
      <script>

        $(".select2").select2({
            width: '100%'
        });

        function myFunction() {

            
            // Get the checkbox
            var checkBox = document.getElementById("is_retour");
            // Get the output text
            var text = document.getElementById("text");
            var ticketList = document.getElementById("ticket_retoure");
            // If the checkbox is checked, display the output text
            if (checkBox.checked == true){
                ticketList.removeAttribute("disabled");
                ticketList.setAttribute("required", "required");
            }
            else{
                ticketList.removeAttribute("required");
                ticketList.setAttribute("disabled", "disabled");
                document.getElementById("article").value = '';
            }
        }

            $(function(){
                // turn the element to select2 select style
                $('#ticket_retoure').select2({
                 placeholder: "choisir le ticket retourné"
                });

                $('#ticket_retoure').on('change', function() {
                //var data = $("#ticket_retoure .select2 option:selected");
               
                var title = $(this).find(":selected").data("article");
                var client = $(this).find(":selected").data("client");
                $('#clientList').select2().val(`${client}`);
                $('#clientList').trigger('change');
                $('#article').trigger('change');
         
                  document.getElementById("article").value = title;
                })
            });
       
    
    </script>
    @endpush

@endonce
