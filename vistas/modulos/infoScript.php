<script>
    $(document).ready(function() {
        $('.btn-modal-help').on('click', function(e) {
            e.preventDefault();
            var token = $(this).attr('href'); //guardamos lo que viene en el atributo href
            swal({
                title: 'Dirección de Tecnologia de la Información y Comunicaciones',
                text: "Subdirección de Desarollo de Programas",
                type: 'info',
                confirmButtonColor: '#03A9F4',
                closeOnConfirm: false
            }).then(function() {});
        });
    });
</script>