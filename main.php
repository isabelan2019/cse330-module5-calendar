<?php
ini_set("session.cookie_httponly", 1);
session_start();
if (isset($_SESSION['userid'])) {
$username=(string) $_SESSION['username'];
$token=$_SESSION['token'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link type="text/css" rel="stylesheet" href="calendar.css">
    <!-- jquery -->
    <link rel="stylesheet" type="text/css"
        href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

</head>

<body>

    <div id="loginform">
        <p>Login</p>
        <label for="username">Username: </label>
        <input type="text" id="username" name="username" placeholder="Username" required>
        <label for="password">Password: </label>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button name="login-btn" id="login-btn"> Log In </button>
    </div>

    <p>New User? Register Below!</p>
    <label for="new-username">New Username: </label>
    <input type="text" id="new-username" name="new-username" placeholder="New Username" required>
    <label for="new-password">New Password: </label>
    <input type="password" id="new-password" name="new-password" placeholder="New Password" required>
    <input type="button" name="create-user" id="create-user" value="Create Account">

    <div id="loggedin">
        <p id="welcometext">
        </p>
        <button id="shareCalendar"> Share Calendar with: </button> <input type="text" id="sharedcal-user" name="sharedcal-user">
        <br><button name='logout-btn' id='logout-btn'> Log Out </button>
    </div>
    
    <?php
        // if (isset($_SESSION['user_id'])) {
        //     // show logout button 
        //     $username=(string) $_SESSION['username'];
        //     printf("<br>not you? <button name='logout-btn' id='logout-btn'> Log Out </button>");
        // }
        // else{ 
        //     //not logged in -- show log in and register user
        //     echo "\n\t 
        //     <div id='loginform'>
        //         <p>Login</p>
        //         <label for='username'>Username: </label>
        //         <input type='text' id='username' name='username' placeholder='Username' required>
        //         <label for='current-password'>Password: </label>
        //         <input type='password' id='password' name='password' placeholder='Password' required>
        //         <button name='login-btn' id='login-btn'> Log In </button>
        //     </div>";

        //     echo "\n\t
        //     <p>New User? Register Below!</p>
        //     <label for='new-username'>New Username: </label>
        //     <input type='text' id='new-username' name='new-username' placeholder='New Username' required>
        //     <label for='new-password'>New Password: </label>
        //     <input type='password' id='new-password' name='new-password' placeholder='New Password' required>
        //     <input type='button' name='create-user' id='create-user' value='Create Account'>
        //     ";
        // }
    ?>

    
    <div id="buttons">
        <button id="prev-month-btn"> Previous Month </button>
        <div id="monthyear">
            <p id="month"></p>
            <p id="year"> </p> 
        </div> 
        <button id="next-month-btn"> Next Month</button>
    </div>
    <br><br><br>
    <div id="display">
        <label> personal:<input name="displaytag" type="checkbox" id="personaldisplay" value="personal" checked/> </label>
        <label> school:<input name="displaytag" type="checkbox" id="schooldisplay" value="school" checked/> </label>
        <label> work:<input name="displaytag" type="checkbox" id="workdisplay" value="work" checked/> </label>
        <label> untagged:<input name="displaytag" type="checkbox" id="otherdisplay" value="all" checked/> </label>

    </div>
    
    <table id="calendar">
        <tr>
            <th>Sun</th>
            <th>Mon</th>
            <th>Tues</th>
            <th>Wed</th>
            <th>Thurs</th>
            <th>Fri</th>
            <th>Sat</th>
        </tr>
        <tr class="week" id="week1">
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
        </tr>
        <tr class="week" id="week2">
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
        </tr>
        <tr class="week" id="week3">
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
        </tr>
        <tr class="week" id="week4">
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
        </tr>
        <tr class="week" id="week5">
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
        </tr>
        <tr class="week" id="week6">
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
            <td class="day">
                <p class="day-num"></p>
                <div class="class-events"></div>
            </td>
        </tr>
    </table>

    <div id="addEventForm">
        <label for="event-title">Event Title: </label>
        <input type="text" id="event-title" name="event-title">
        <label for="date">Event Date: </label>
        <input type="date" id="date" name="date">
        <label for="time">Event Time: </label>
        <input type="time" id="time" name="time">
        <label> personal:<input name="tag" type="radio" id="personal" value="personal"/> </label>
        <label> school:<input name="tag" type="radio" id="school" value="school" /> </label>
        <label> work:<input name="tag" type="radio" id="work" value="work" /> </label>
        <input type='hidden' id="addToken" value="">
        <button id="add"> Add Event</button>
    </div>
    <div id="event-details" title="Edit Event">
        <p id="event-description"></p>
        <label for="new-event-title">Event Title: </label>
        <input type="text" id="new-event-title" name="new-event-title"> <br>
        <label for="new-date">Event Date: </label>
        <input type="date" id="new-date" name="new-date"> <br>
        <label for="time">Event Time: </label>
        <input type="time" id="new-time" name="new-time"> <br>
        <label> personal:<input name="new-tag" type="radio" id="new-personal" value="personal"/> </label>
        <label> school:<input name="new-tag" type="radio" id="new-school" value="school" /> </label>
        <label> work:<input name="new-tag" type="radio" id="new-work" value="work" /> </label> <br>
        <input type='hidden' id="editToken" value=""> 
        <button id="edit"> Edit Event</button> 
        <button id="delete"> Delete Event</button> <br>
        <button id="share"> Share Event with: </button> <input type="text" id="shared-user" name="shared-user">
    </div>

    <script>

        document.getElementById("create-user").addEventListener("click", createuserAjax, false);
        document.getElementById("login-btn").addEventListener("click", loginAjax, false);
        document.getElementById("add").addEventListener("click", addEvent, false);
        document.getElementById("logout-btn").addEventListener("click", logoutAjax, false);
        document.getElementById("shareCalendar").addEventListener("click", shareCalendar, false);

        document.getElementById('personaldisplay').addEventListener("change", updateCalendar, false);
        document.getElementById('schooldisplay').addEventListener("change", updateCalendar, false);
        document.getElementById('workdisplay').addEventListener("change", updateCalendar, false);
        document.getElementById('otherdisplay').addEventListener("change", updateCalendar, false);


        //add event to server
        function addEvent(event) {
            event.preventDefault();
            const title = document.getElementById("event-title").value;
            const time = document.getElementById("time").value;
            const date = document.getElementById("date").value;
            const addToken = document.getElementById("addToken").value;
            
            let tags = document.getElementsByName('tag');
            let checkedtag =null;
            for (let i=0; i<tags.length; i++){
                if (tags[i].checked){
                    checkedtag = tags[i].value;
                }
            }
            //console.log(checkedtag);
              
            const data = { 'title': title, 'date': date, 'time': time, 'tag':checkedtag, 'token': addToken };
            fetch("addevent.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.loggedin == false) {
                    console.log(data.loggedin);
                    alert("You must be logged in.");
                }
                else {
                    updateCalendar();
                    alert(data.success ? "Event added" : `Event unable to be added:${data.message}`);

                }
            })
                // .then(response=>response.text())
                // .then(text=>console.log(text))
            .catch(err => console.error(err));
            document.getElementById('event-title').value = "";
            document.getElementById('date').value = "";
            document.getElementById('time').value = "";
        }

        //log in
        function loginAjax(event) {
            const username = document.getElementById("username").value; // Get the username from the form
            const password = document.getElementById("password").value; // Get the password from the form
            // Make a URL-encoded string for passing POST data:
            const data = { 'username': username, 'password': password };
            let loginToken=null;
            fetch("login.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
                .then(response => response.json())
                .then(data => {
                    //console.log(data);
                    console.log(data.success ? "You've been logged in!" : `You were not logged in ${data.message}`);
                    if (data.success == true) {
                        loginToken = data.token;
                        console.log(data.token);
                        console.log(loginToken);
                        //hidden token to addevent form 
                        document.getElementById('addToken').value =data.token;

                        alert("You've successfully logged in!");
                        updateCalendar();
                        //document.getElementbyId('logout-btn').style.visibility='visible';
                    }
                    else {
                        alert("Incorrect Username or Password. Try again");
                    }
                })
                .catch(err => console.error(err));

                //hidden token to addevent form 
                document.getElementById('addToken').value = loginToken;
                
                //input reset
                document.getElementById('username').value = "";
                document.getElementById('password').value = "";

        }
        
        
        //log out
        function logoutAjax(event) {
            fetch("logout.php")
                .then(response => response.json())
                .then(data => {
                    if (data.success == true) {
                        //remove tokens 
                        document.getElementById("addToken").value = null;
                        let eventTokens = document.getElementsByClassName('token');
                        for (let t in eventTokens) {
                            document.getElementsByClassName('token')[t].value = null;
                        }
                        // document.getElementById("token2").value=null;
                        alert("You've been successfully logged out!");
                        //document.getElementbyId('logout-btn').style.visibility='hidden';
                        updateCalendar();
                    }
                    else {
                        alert("Try logging out again.");
                    }
                })
                .catch(err => console.error(err));
            updateCalendar();
            document.getElementById('addToken').value ="";
            document.getElementById('welcometext').innerHTML =" ";

        }
        //create user
        function createuserAjax(event) {
            event.preventDefault;
            const newUsername = document.getElementById("new-username").value; // Get the username from the form
            const newPassword = document.getElementById("new-password").value; // Get the password from the form
            // Make a URL-encoded string for passing POST data:
            const data = { 'new-username': newUsername, 'new-password': newPassword }
            fetch("createuser.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data.success ? "Your account has been created!" : `Your account was unable to be created: ${data.message}`);
                    if (data.exists == true) {
                        alert("This username already exists. Please choose another");
                    }
                    else if (data.invalid == true) {
                        alert("Invalid Characters. Please choose a username with alphanumeric characters only.")
                    }
                    else if (data.success == true) {
                        alert("Your account has been created!");
                    }
                    else {
                        alert("Your account was unable to be created. Please try again.");
                    }
                })
                .catch(err => console.error(err));
            document.getElementById('new-username').value = "";
            document.getElementById('new-password').value = "";
        }

        //calendar helper functions
        (function () {
            //returns a date object c days in the future
            Date.prototype.deltaDays = function (c) {
                return new Date(this.getFullYear(), this.getMonth(), this.getDate() + c)
            };
            //returns Sunday nearest in the past to this day
            Date.prototype.getSunday = function () {
                return this.deltaDays(-1 * this.getDay())
            }
        })();

        function Week(c) {
            this.sunday = c.getSunday();
            //returns a week object sequentially in the future
            this.nextWeek = function () {
                return new Week(this.sunday.deltaDays(7))
            };
            //returns a week object sequentially in the past
            this.prevWeek = function () {
                return new Week(this.sunday.deltaDays(-7))
            };
            //returns true if this week's sunday is the same as date's sunday; false otherwise
            this.contains = function (b) {
                return this.sunday.valueOf() === b.getSunday().valueOf()
            };
            //returns an Array containting 7 Date objects, each representing one of the seven days in this month
            this.getDates = function () {
                for (var b = [], a = 0; 7 > a; a++)
                    b.push(this.sunday.deltaDays(a));
                return b
            }
        }
        function Month(c, b) {
            //year associated with the month
            this.year = c;
            //month number (january = 0)
            this.month = b;
            //returns a month object sequentially in the future
            this.nextMonth = function () {
                return new Month(c + Math.floor((b + 1) / 12), (b + 1) % 12)
            };
            //returns a month object sequentially in the past
            this.prevMonth = function () {
                return new Month(c + Math.floor((b - 1) / 12), (b + 11) % 12)
            };
            //returns a date object representing the date d in the month
            this.getDateObject = function (a) {
                return new Date(this.year, this.month, a)
            };
            //returns an array containing all weeks spanned by the month; the weeks are represented as week objects
            this.getWeeks = function () {
                var a = this.getDateObject(1), b = this.nextMonth().getDateObject(0), c = [], a = new Week(a);
                for (c.push(a); !a.contains(b);)a = a.nextWeek(), c.push(a);
                return c
            }
        };

        // For our purposes, we can keep the current month in a variable in the global scope
        let currentMonth = new Month(2020, 10); // november 2020 (January = 0)

        //load calendar
        document.addEventListener("DOMContentLoaded", updateCalendar, false);
        // Change the month when the "next" button is pressed
        document.getElementById("next-month-btn").addEventListener("click", function (event) {
            currentMonth = currentMonth.nextMonth();
            updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
            // alert("The new month is " + currentMonth.month + " " + currentMonth.year);
        }, false);

        // Change the month when the "prev" button is pressed
        document.getElementById("prev-month-btn").addEventListener("click", function (event) {
            currentMonth = currentMonth.prevMonth();// Previous month would be currentMonth.prevMonth()
            updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
            //   alert("The new month is " + currentMonth.month + " " + currentMonth.year);
        }, false);


        //render calendar
        function updateCalendar() {
            let monthTitle = "";
            if (currentMonth.month == 0) {
                monthTitle = "January ";
            } else if (currentMonth.month == 1) {
                monthTitle = "February ";
            } else if (currentMonth.month == 2) {
                monthTitle = "March ";
            } else if (currentMonth.month == 3) {
                monthTitle = "April ";
            } else if (currentMonth.month == 4) {
                monthTitle = "May ";
            } else if (currentMonth.month == 5) {
                monthTitle = "June ";
            } else if (currentMonth.month == 6) {
                monthTitle = "July ";
            } else if (currentMonth.month == 7) {
                monthTitle = "August ";
            } else if (currentMonth.month == 8) {
                monthTitle = "September ";
            } else if (currentMonth.month == 9) {
                monthTitle = "October ";
            } else if (currentMonth.month == 10) {
                monthTitle = "November ";
            } else if (currentMonth.month == 11) {
                monthTitle = "December ";
            }

            //let sessiontoken=document.getElementById('addToken').value;
            //console.log(sessiontoken);
            //hidden token to addevent form 
            //document.getElementById('addToken').value = sessiontoken;

            

            document.getElementById("month").textContent = monthTitle;
            //currentMonth.month;
            document.getElementById("year").textContent = currentMonth.year;

            //clear calendar dates
            let date = document.getElementsByClassName("day-num");
            for (let d in date) {
                document.getElementsByClassName("day-num")[d].textContent = "";
            }

            let weeks = currentMonth.getWeeks();

            for (let w in weeks) {
                let days = weeks[w].getDates();
                // days contains normal JavaScript Date objects.
                // alert("Week starting on "+days[0]);
                for (let d in days) {
                    document.getElementsByClassName("week")[w].children[d].children[1].innerHTML = "";
                    document.getElementsByClassName("week")[w].children[d].firstElementChild.textContent = days[d].getDate();
                    document.getElementsByClassName("week")[w].children[d].id = days[d].toISOString().split('T')[0];

                }
            }
            //get events 
            
            const personaldisplay = document.getElementById('personaldisplay').checked;
            const schooldisplay =document.getElementById('schooldisplay').checked;
            const workdisplay = document.getElementById('workdisplay').checked; 
            const otherdisplay = document.getElementById('otherdisplay').checked;


            const data = {"personal":personaldisplay, "school": schooldisplay, "work": workdisplay, "other": otherdisplay};
            console.log(data);
            fetch("getevents.php",{
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.loggedin != false) {
                        console.log('Success', JSON.stringify(data));
                        //console.log(data);
                        parseEvents(data);
                    }
                })
                //.then(response=>response.text())
                //.then(text=>console.log(text))
                .catch(err => console.error(err));

        }
        //parse out events based on database events
        function parseEvents(response) {
            

            let jsonData = JSON.parse(JSON.stringify(response));
            //console.log(jsonData[0].username);
            document.getElementById('welcometext').innerHTML = jsonData[0].username+"'s Calendar";
            document.getElementById('display').style.visibility = 'visible'; 
            let calendar_days = document.getElementsByClassName("day");
            for (let i = 0; i < calendar_days.length; i++) {
                let calendar_date = calendar_days[i].id;
                for (let n = 0; n < jsonData.length; n++) {
                    if (calendar_date == jsonData[n].date) {
                        let eventID = jsonData[n].event_id;
                        if (document.getElementById(eventID) == null) {
                            //create div to hold event
                            let event = document.createElement('div');
                            let eventText=" ";
                            if (jsonData[n].username == 'shared'){
                                //shared calendar event
                                eventText = document.createTextNode("shared event: "+jsonData[n].title + " at " + jsonData[n].time);
                            }
                            else {
                                //show event title and event time
                                eventText = document.createTextNode(jsonData[n].title + " at " + jsonData[n].time);
                            }
                            event.appendChild(eventText);
                            //set id of this div to the eventID
                            event.id = eventID;
                            event.setAttribute('class',jsonData[n].tags);
                            //append this div to the div class events 
                            document.getElementById(calendar_date).children[1].appendChild(event);
                            //show dialogue box
                            document.getElementById(calendar_date).children[1].addEventListener("click", showDialog, false);

                            //hidden token to events
                            let eventToken = document.createElement('input');
                            eventToken.value=jsonData[n].token;
                            //appendChild(document.createTextNode(jsonData[n].token));
                            eventToken.id = "token"+eventID;
                            eventToken.setAttribute('type', 'hidden');
                            event.appendChild(eventToken);
                            //document.getElementById(calendar_date).children[1].appendChild(eventToken);

                            //hidden token to addevent form 
                            document.getElementById('addToken').value = jsonData[n].token;
                            //hidden token to edit event details form 
                            //document.getElementById('editToken').value = jsonData[n].token;

                        }

                    }
                }
            }
        }

        function showDialog(event) {
            let eventid = event.target.id; //use to access the specific event in mysql
            //console.log(eventToken);
            $("#event-details").dialog();

            document.getElementById("edit").addEventListener("click", editEvent, false);
            document.getElementById("delete").addEventListener("click", deleteEvent, false);
            document.getElementById("share").addEventListener("click", shareEvent, false);


            //edit event 
            function editEvent(event) {
                event.preventDefault();
                const ntitle = document.getElementById("new-event-title").value;
                const ntime = document.getElementById("new-time").value;
                const ndate = document.getElementById("new-date").value;
                const token = document.getElementById("token"+eventid).value;
                let tags = document.getElementsByName('new-tag');
                let checkedtag =null;
                for (let i=0; i<tags.length; i++){
                    if (tags[i].checked){
                      checkedtag = tags[i].value;
                    }
                }

                const data = { 'new-event-title': ntitle, 'new-date': ndate, 'new-time': ntime, 'new-tag':checkedtag, 'eventid': eventid, 'token': token };
                fetch('editevent.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: { 'content-type': 'application/json' }
                })
                    .then(response => response.json())
                    // .then(response=>response.text())
                    //  .then(text=>console.log(text))
                    .then(data => {
                        updateCalendar();
                        alert(data.success ? "Event changed" : `Could not be edited: ${data.message}`);
                    })

                    .catch(err => console.error(err));
                document.getElementById('new-event-title').value = "";
                document.getElementById('new-date').value = "";
                document.getElementById('new-time').value = "";
                $("#event-details").dialog('close');
            }

            function deleteEvent(event) {
                console.log(eventid);
                event.preventDefault();
                const token = document.getElementById("token"+eventid).value;
                console.log(token);
                const data = { 'eventid': eventid, 'token':token };
                fetch('deleteevent.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: { 'content-type': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.success ? "Event deleted" : `Could not be deleted: ${data.message}`);
                    updateCalendar();
                })
                .catch(err => console.error(err));
                $("#event-details").dialog('close');

            }
            function shareEvent(event){
                event.preventDefault();
                const shareuser =  document.getElementById("shared-user").value;
                const token = document.getElementById("token"+eventid).value;
                const data = { 'eventid': eventid, 'shareuser':shareuser, 'token':token };
                fetch('shareevent.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: { 'content-type': 'application/json' }
                }) 
                .then(response => response.json())
                .then(data => {
                    if (data.exists == false) {
                        alert("This user does not exist. Please choose another");
                    } 
                    // if (data.sameuser == true) {
                    //     alert("you cannot share with yourself");
                    // }
                    else {
                        updateCalendar();
                        //console.log(data);
                        alert(data.success ? "Event shared" : `Could not be shared: ${data.message}`);

                    }
                    
                })
                .catch(err => console.error(err));
                document.getElementById('shared-user').value = "";
                $("#event-details").dialog('close');
            }
        }

        function shareCalendar(event){
            const sharecal = document.getElementById('sharedcal-user').value;
            //add token value 
            const data= {'sharecal':sharecal};
            fetch('sharecalendar.php', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.exists == false) {
                        alert("This user does not exist. Please choose another");
                    } else if (data.sameuser == true) {
                        alert("you cannot share with yourself");
                    } else {
                        console.log(data);
                        updateCalendar();
                        alert(data.success ? "Calendar shared" : `Calendar could not be shared: ${data.message}`);

                    }
                    
                })
                .catch(err => console.error(err));
                document.getElementById('sharedcal-user').value = "";
        }



    </script>
</body>

</html>