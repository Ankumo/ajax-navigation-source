
$('a[href]:not([class="away-link"])').click(function (e) {
    e.preventDefault();
    getContent($(this).attr('href'));
    history.pushState(null, null, $(this).attr('href'));
});

window.addEventListener("popstate load", function (e) {
    getContent(location.pathname);
});

function getContent(url) {
    $.ajax({
        url: "/scripts/ajaxGetPage.php",
        type: "POST",
        data: {
            url: url
        },
        success: function(data) {
            console.log(data);
            $('div.main').empty().html(data);
        }
    });
} 

getContent(location.pathname);