var counter=1;

function init() {
    console.log("Welcome."+counter);
    counter ++;
    if (counter==4) {
        console.log("Done!");
        document.getElementById('start-box').style.display="none";
        document.getElementById('content').innerHTML = "></br>></br>            <p>We would also like to hear about you! If you have any inquires about any of our products and services or if you are looking for a cool new job, just say hi to <a href=\"mailto:click@uiloops.com\">click</a>@uiloops.com We will reply back soon enough!</p>";
    }
}
