<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
{{-- Search Input --}}
<div class="container">
    <form id="searchForm" class="form-inline mt-3 mb-3">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="search_title">
    </form>
</div>

{{-- Products --}}
<div class="container" id="products">
    @include('pagination')
</div>

<script>
    $(document).ready(function() {
        $('#search_title').on('keyup', function() {
            fetchProducts(1);
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetchProducts(page);
        });

        function fetchProducts(page) {
            var keyword = $('#search_title').val().trim();
            $.ajax({
                url: '/search',
                data: {
                    page: page,
                    keyword: keyword
                },
                success: function(data) {
                    $('#products').html(data);
                }
            });
        }
    });
</script>

</body>


</html>

