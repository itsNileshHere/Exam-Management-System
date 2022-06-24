const togglePasswordEye = '<i class="fa fa-eye toggle-password-eye"></i>';
const togglePasswordEyeSlash = '<i class="fa fa-eye-slash toggle-password-eye"></i>';

$(togglePasswordEyeSlash).insertAfter('input[type=password]');
$('input[type=password]').addClass('hidden-pass-input')

$('body').on('click', '.toggle-password-eye', function (e) {
    let password = $(this).prev('.hidden-pass-input');

    if (password.attr('type') === 'password') {
        password.attr('type', 'text');
        $(this).addClass('fa-eye').removeClass('fa-eye-slash');
    } else {
        password.attr('type', 'password');
        $(this).addClass('fa-eye-slash').removeClass('fa-eye');
    }
})