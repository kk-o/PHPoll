#!/usr/local/bin/php
<?php
print('<?xml version="1.0" encoding="utf-8"?>');
print("\n");
date_default_timezone_set('America/Los_Angeles');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <title>Your Poll</title>

    <link rel="stylesheet" type="text/css" href="CREATE_POLL.css" />
    <script type='text/javascript'>
        <!--
        var option3 = false; //keeps tracks of how many answer choices the user chooses
        var option4 = false;
        var sess_id;


        function init() { //initializes animation

            if (document.getElementById("figure1") != null) {
                var figure_1 = document.getElementById("figure1");
                var figure_2 = document.getElementById("figure2");
                figure_1.style.position = "relative";
                figure_1.style.left = "-180px";
                figure_1.style.top = "0px";
                figure_2.style.position = "relative";
                figure_2.style.left = "180px";
                figure_2.style.top = "0px";
                t = 0;
            }
            if (document.getElementById("id").value != "") {
                sess_id = document.getElementById("id").value;
                var start = document.getElementsByClassName("startform");
                start[0].style.display = "none";
                var poll = document.getElementsByClassName("pollform");
                poll[0].style.display = "block";
                query_string = "poll_id=" + document.getElementById("id").value;
                linked_form(query_string);
            } //read from database

        }

        function linked_form(query_string) {

            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var result = xhr.responseText; //everything php prints, use dom methods to write
                    create_form(result); //form creation
                }
            }
            xhr.open('GET', 'connect_questions.php?' + query_string, true);
            xhr.send(null);
        }

        function refresh_data(query_string) {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var result = xhr.responseText; //everything php prints, use dom methods to write
                    display_result(result);
                }
            }
            xhr.open('GET', 'ajax_update.php?' + query_string, true);
            xhr.send(null);
        }
        /*
        Displays results of poll
        */
        function show_results() {
            var results = document.getElementById("results");
            results.style.display = "block";
        }
        /*
        Gets query string to create a poll
        */
        function process_poll() {
            var let1 = String.fromCharCode(97 + Math.round(Math.random() * 25));
            var rand_ints = Math.floor(Math.random() * 90000) + 10000;
            var question_f = document.getElementById("question_field").value;

            var opp1 = document.getElementById("option_1").value;
            var opp2 = document.getElementById("option_2").value;
            var opp3 = document.getElementById("option_3").value;
            var opp4 = document.getElementById("option_4").value;

            if (opp1 == "" || opp2 == "" || question_f == "") {
                if (option3 == true) {
                    if (option4 != true) {
                        alert("Please fill out all parts of this page!");
                    } else if (option4 == true) {
                        if (opp4 == "") {
                            alert("Please fill out all parts of this page!");
                        }
                    }
                } else {
                    alert("Please fill out all parts of this page!");
                }
            } else {
                var query_string = "poll_id=" + let1 + rand_ints + "&question=" + question_f + "&opp1=" + opp1 + "&opp2=" + opp2;
                sess_id = let1 + rand_ints;
                if (opp3 != "") {
                    query_string = query_string + "&opp3=" + opp3;
                }
                if (opp4 != "") {
                    query_string = query_string + "&opp4=" + opp4;
                }
                var div = document.getElementsByClassName("startform");
                div[0].style.display = "none"; // hides creation form

                var poll_form = document.getElementsByClassName("pollform");
                poll_form[0].style.display = "block";

                var alert_p = document.createElement("p");
                document.body.appendChild(alert_p);
                var a = document.createElement('a');
                var linkText = document.createTextNode("Click here to share this poll!");
                a.appendChild(linkText);
                a.title = "My Poll";
                a.href = "new_poll.php?" + "id=" + let1 + rand_ints;
                alert_p.appendChild(a);

                var id = document.getElementById("id").value;
                if (id == "" || id == "undefined") {
                    id = let1 + rand_ints;
                }
                create_form_ajax(query_string, id);
            }

        }
        /*
        This function sends the information needed to create a form with Ajax
        */
        function create_form_ajax(query_string, id) {

            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var result = xhr.responseText; //everything php prints, use dom methods to write
                    create_form(result, id);
                }
            }
            xhr.open('GET', 'new_poll_2.php?' + query_string, true);
            xhr.send(null);
        }
        /*
        Creates form if user is directed to the page from a link
        */
        function create_form(result, id) {
            var id_new = document.getElementById("id");
            id_new.value = id;
            result_arr = result.split(";");

            var question = result_arr[0];
            var question_id = document.getElementById("question");
            question_id.innerHTML = question;
            var opp_1 = document.getElementById("opp1_radio");
            var text1 = result_arr[1];
            opp_1.innerHTML += text1;
            var opp_2 = document.getElementById("opp2_radio");
            var text2 = result_arr[2];
            opp_2.innerHTML += text2;
            if (result_arr[3] != "not_set" && result_arr[3] != "") //Checks to see if option3 is written
            {
                var opp_3 = document.getElementById("opp3_radio");
                var text3 = result_arr[3];
                opp_3.innerHTML += text3;
                opp_3.style.display = "inline";
                var opp_3_div = document.getElementsByClassName("radio3");
                opp_3_div[0].style.display = "inline";
                document.getElementById("opp_3").style.display = "inline";
                option3 = true;

                if (result_arr[4] != "not_set" && result_arr[4] != "") //Checks to see if option4 is written
                {
                    var opp_4 = document.getElementById("opp4_radio");
                    var text4 = result_arr[4];
                    opp_4.innerHTML += text4;
                    opp_4.style.display = "inline";
                    var opp_4_div = document.getElementsByClassName("radio4");
                    opp_4_div[0].style.display = "inline";

                    document.getElementById("opp_4").style.display = "inline";
                    option4 = true;

                } else {
                    option4 = false;
                }
            } else {
                option3 = false;
            }
        }
        /* This function returns the contents of a cookie by name
         */
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        /* Checks if a cookie that matches the id of the current poll exists.
         */
        function getId(cname, id) {
            var id_exists = false;
            if (getCookie(cname) != "") {
                var id_arr = getCookie(cname).split(',');
                id_arr[id_arr.length - 1] = id_arr[id_arr.length - 1].substring(0, id_arr[id_arr.length - 1].length - 1);
                for (var i = 0; i < id_arr.length; i++) {
                    if (id_arr[i] == id) {
                        id_exists = true;
                    }
                }
            }
            return (id_exists);
        }
        /*
        This function sends which answer the user voted for to Ajax and then allows the results to be displayed.
        */
        function process_answers() {

            var vote;

            var one_check = document.getElementById("opp_1").checked;
            var two_check = document.getElementById("opp_2").checked;
            if (option3 == true) {
                var three_check = document.getElementById("opp_3").checked;
            }
            if (option4 == true) {
                var four_check = document.getElementById("opp_4").checked;
            }

            /*Checks if user has already voted*/
            if (getCookie("user") == "" || getId("user", sess_id) == false) {
                if (getCookie("user") == "") {
                    document.cookie = "user=" + sess_id + ",";
                } else if (getId("user", id) == false) {
                    document.cookie = "user=" + getCookie("user") + sess_id + ",";
                } else {}

                if (one_check) {
                    vote = "vote=opp_1";
                } else if (two_check) {
                    vote = "vote=opp_2";
                } else if (three_check) {
                    vote = "vote=opp_3";
                } else if (four_check) {
                    vote = "vote=opp_4";
                }

                query_string = "id=" + sess_id + "&" + vote;
            } else {
                query_string = "id=" + sess_id;

                alert("You already voted in this poll!");
            }
            do_ajax(query_string);
            var ajax_string = "id=" + sess_id;
            setInterval(function() {
                refresh_data(ajax_string);
            }, 1000);
        }

        function do_ajax(query_string) {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var result = xhr.responseText;
                    display_result(result); // Changes the sizes of the divs
                }
            }
            xhr.open('GET', 'update_data.php?' + query_string, true);
            xhr.send(null);
        }
        /*
        Displays results after user votes
        */
        function display_result(result) {
            var vote_3_amt = 0;
            var vote_4_amt = 0;

            result1 = result.split(';');
            var one_label = document.getElementById("opp1_label");
            var two_label = document.getElementById("opp2_label");

            one_label.innerHTML = result1[0] + " votes";
            two_label.innerHTML = result1[1] + " votes";


            var total_vote = parseInt(result1[0]) + parseInt(result1[1]);

            if (option3 == true) {
                var three_label = document.getElementById("opp3_label");
                three_label.innerHTML = result1[2] + " votes";
                three_label.style.display = "block";
                var three_div = document.getElementById("opp3_votes");
                three_div.style.display = "block";

                vote_3_amt = parseInt(result1[2]);

                total_vote += vote_3_amt;

                if (option4 == false) {
                    var three_width = vote_3_amt / total_vote * 200;
                    three_div.style.width = three_width + 'px';
                }

                if (option4 == true) {
                    var four_label = document.getElementById("opp4_label");
                    four_label.innerHTML = result1[3] + " votes";
                    four_label.style.display = "block";
                    var four_div = document.getElementById("opp4_votes");
                    four_div.style.display = "block";

                    vote_4_amt = parseInt(result1[3]);

                    total_vote += vote_4_amt;
                    var four_width = vote_4_amt / total_vote * 200;
                    four_div.style.width = four_width + 'px';

                    var three_width = vote_3_amt / total_vote * 200;
                    three_div.style.width = three_width + 'px';
                }
            }

            var one_div = document.getElementById("opp1_votes");
            var two_div = document.getElementById("opp2_votes");

            var one_width = parseInt(result1[0]) / total_vote * 200;
            var two_width = parseInt(result1[1]) / total_vote * 200;
            one_div.style.width = one_width + 'px';
            two_div.style.width = two_width + 'px';
            show_results();
        }
        /*
        Animates the two figures fighting each other
        */
        function animate_figures() {
            if (t < 200) {
                var figure_1 = document.getElementById("figure1");
                var figure_2 = document.getElementById("figure2");

                var left_1 = figure_1.style.left;
                var left_2 = figure_2.style.left;

                left_1 = parseInt(left_1);
                left_2 = parseInt(left_2);

                left_1 = left_1 + 1;
                left_2 = left_2 - 1;
                left_1 = left_1 + "px";
                left_2 = left_2 + "px";
                figure_1.style.left = left_1;
                figure_2.style.left = left_2;

                setTimeout(animate_figures, 20);
                t++;
            } else if (t == 200) {
                alert("It's a tie!");
            }
        }
        /*
        Allows user to add more answer options
        */
        function toggleCheckbox() {

            var option3_content = document.getElementById("option_3");
            var option4_content = document.getElementById("option_4");

            if (option3 == false) {
                option3_content.style.display = "inline";

                var option3_label = document.getElementById("opp3_ans");
                option3_label.style.display = "inline";
                option3 = true;
            } else if (option3 == true) {
                option4_content.style.display = "inline";

                var option4_label = document.getElementById("opp4_ans");
                option4_label.style.display = "inline";
                option4 = true;
            }
        } //-->
    </script>
</head>

<body onload="init()">
    <div class="header">
        <img src="pick_poll.png" alt="header image: pick a poll" width="50%" />
    </div>
    <?php
    if (isset($_GET['id'])) {
      $getid = $_GET['id'];
    } else {
      $getid = "";
    }

    echo "<div class ='pollform'>";
    echo "<p id ='question'>", "</p>";
    echo "<fieldset>
                <form action='update_data.php' method='get'>
					<p>
                       ", "<label for='opp_1' id = 'opp1_radio'>", /*GET one*/"<input type='radio' name='vote' value='opp_1' id = 'opp_1'/></label><br/>
                        ", "<label for='opp_2' id = 'opp2_radio'>", /*GET two*/"<input type='radio' name='vote' value='opp_2' id = 'opp_2'/></label><br/>";

    echo "</p><div class = 'radio3'><label for='opp_3' id = 'opp3_radio'>", /*GET three*/"<input type='radio' name='vote' value='opp_3' id = 'opp_3'/></label><br/></div>";
    echo "<div class = 'radio4'><label for='opp_4' id = 'opp4_radio'>", /*GET four: use javascript*/"<input type='radio' name='vote' value='opp_4' id = 'opp_4'/></label><br/></div>";

    echo "<p><input type='hidden' id = 'id' name='id' value ='", $getid, "' /></p>";
    echo "<p> <input type='button' value='SEE THE RESULTS' onclick='process_answers()' class = 'button'/></p>
                </form>
         </fieldset>";

    echo "<div id = 'results'>
			<p id = 'opp1_label'></p>
			<div id='opp1_votes'>";

    echo "</div>", "<p id = 'opp2_label'></p><div id='opp2_votes'></div>
			</div>

			<p id = 'opp3_label'></p>
			<div id='opp3_votes'></div>

			<p id = 'opp4_label'></p>
			<div id='opp4_votes'>";
    echo "</div>";
    echo "</div>";

    echo "<div class='startform'>
<h3>Who Will Win?</h3>
<p>What do you want to know? Enter your question (no semicolons) and question choices below.</p>
<form id='form1' action='new_poll_2.php' method='get'>
<fieldset>
	<legend></legend>
<table>
<tr>
<th>
<label for='question'>What's your question?</label>
<input type='text' name='question' id='question_field'/>
</th>
</tr>
		<tr>
		<td>
		<label for='option_1'>Answer Choice:</label>
		</td>
		</tr>
		<tr>
		<td><input type='text' name='person1' id='option_1'/>
		</td>
		</tr>
		<tr>
		<td>
		<label for='option_2'>Answer Choice:</label></td>
		</tr>
		<tr>
		<td><input type='text' name='person2' id='option_2'/>
		</td>
		</tr>
		<tr>
		<td>
		<label for='option_3' id = 'opp3_ans'>Answer Choice:</label>
		</td>
		</tr>
		<tr>
		<td><input type='text' name='person3' id='option_3'/>
		</td>
		</tr>
		<tr>
		<td>
		<label for='option_4' id = 'opp4_ans'>Answer Choice:</label>
		</td>
		</tr>
		<tr>
		<td><input type='text' name='person4' id='option_4'/>
		</td>
		</tr>
</table>
		More answers?<input type='checkbox' name='answerchoices' value='More_choices' id = 'checkbox' onchange='toggleCheckbox()'/><br/>
		<input type='button' value='CREATE A POLL' onclick='process_poll()' class = 'button'/>
</fieldset>
</form>
</div>
<div class = 'animation'>
<div id = 'figure1'><img src='punch_1.png' alt='figure 1'/></div>
<div id = 'figure2'><img src='punch_2.png' alt='figure 2'/></div>
<br/>
<input type='button' value='who would win in a fight?' onclick='animate_figures()' class = 'button'/>
</div>
";

    ?>
</body>

</html> 