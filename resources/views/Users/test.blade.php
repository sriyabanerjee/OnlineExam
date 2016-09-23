@extends('master')
@section('title', 'testPage')
@section('header')
    <link href="{{ URL::asset('../app/assets/vendors/css/jquery.bootgrid.css')}}" rel="stylesheet" />
@endsection
@section('content')
    <table id="grid-data" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th data-column-id="id" data-type="numeric" data-order="asc">ID</th>
                <th data-column-id="firstName" >FirstName</th>
                <th data-column-id="lastName" >LastName</th>
                <th data-column-id="address" >Address</th>
                <th data-column-id="link" data-formatter="link" data-sortable="false">Link</th>
            </tr>
        </thead>
    </table>


  
@endsection
@section('footer')
    <script src="{{ URL::asset('../app/assets/vendors/js/jquery.bootgrid.min.js')}}"></script>
    <script type="text/javascript">
        $("#grid-data").bootgrid({
        ajax: true,
        post: function ()
        {
            /* To accumulate custom parameter with the request object */
            return {
                id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                
            };
        },
        url: "bootgrid",
        formatters: {
            "link": function(column, row)
            {
                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
            }
        }
        
   });
   
    </script>
@endsection