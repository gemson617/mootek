function get_state(country_id) {
    // console.log(country_id);
    $.ajax({
        url: "{{route('get.state')}}",
        method: "POST",
        type: "ajax",
        data: {
            "_token": "{{ csrf_token() }}",
            country_id: country_id
        },
        success: function(result) {
            console.log(result);
            var data = JSON.parse(result);
            $('#state')
                .find('option')
                .remove();
            $.each(data, function(key, value) {
                var option = '<option value="' + value.id + '">' + value.name +
                    '</option>';
                $('#state').append(option);
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function get_city(state_id) {
    $.ajax({
        url: "{{route('get.city')}}",
        method: "POST",
        type: "ajax",
        data: {
            "_token": "{{ csrf_token() }}",

            state_id: state_id
        },
        success: function(result) {
            var data = JSON.parse(result);
            // alert(data);
            $('#city')
                .find('option')
                .remove();
            $.each(data, function(key, value) {
                var option = '<option value="' + value.id + '">' + value.name +
                    '</option>';
                $('#city').append(option);
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
}