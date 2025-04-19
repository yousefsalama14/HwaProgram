function weightCalc(num, decimals) {
    return Math.round(num * Math.pow(10, decimals)) / Math.pow(10, decimals);
}
$(function () {
    var content = $('#thickness').val();
    $('#thickness').keyup(function () {
            content = $('#thickness').val();
            var thickness = $("#thickness").val();
            var length = $("#length").val();
            var width = $("#width").val();
            var total = (7.85 / 10000) * (thickness * length * width);
            // var total = thickness * length * width;
            total = weightCalc(total, 3);
            $("#weight").val(total + " كجم ");
    });

    $('#length').keyup(function () {
            content = $('#length').val();
            var thickness = $("#thickness").val();
            var length = $("#length").val();
            var width = $("#width").val();
            var total = (7.85 / 10000) * (thickness * length * width);
            // var total =  thickness * length * width;
            total = weightCalc(total, 3);
            $("#weight").val(total + " كجم ");
    });

    $('#width').keyup(function () {
            content = $('#width').val();
            var thickness = $("#thickness").val();
            var length = $("#length").val();
            var width = $("#width").val();
            var total = (7.85 / 10000) * (thickness * length * width);
            // var total =  thickness * length * width;
            total = weightCalc(total, 3);
            $("#weight").val(total + " كجم ");
    });
});
