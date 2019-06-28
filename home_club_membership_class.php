<?php  
//    Name:       Seth Romanowski
//    Course:     Web Programming
//    Assignment: Assignment #5 - Club Membership Class

    class Club {
        private $HostName;
        private $UserID;
        private $Password;
        private $DBName;

        public $Con;

        public function __construct(
            $host = NULL,
            $uid = NULL,
            $pw = NULL,
            $db = NULL
        ) {
            //echo("The class constructor is being called... <br />");
            $this->HostName = $host;
            $this->UserID = $uid;
            $this->Password = $pw;
            $this->DBName = $db;
            // Connect to Database
            $this->Con = mysqli_connect($host, $uid, $pw, $db);
            if (mysqli_connect_errno($this->Con)) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
        }

        public function __destruct()
        {
            //echo("The class destructor is being called... <br />");
            // Close connection
            mysqli_close($this->Con);
        }

        function DisplayAbout()
        {
            
            echo ("<h1>About The Informatics Club </h1>");
            echo ("<div id='About'> ");
            echo ("<p> The informatics club is a student organization .....</p> ");
            echo ("<img src='https://www.iusb.edu/tour/images/tour-pics/tourpic20.jpg'
                    width='240' align='right'> ");
            echo ("<p>
                    purpose of the informatics club is to .....
                    Second paragraph ...... Second paragraph Second paragraph......
                    Second paragraph ...... Second
                    </p>");
            echo ("<h3>Our activities and events include: </h3>");
            echo ("<ol>
                    <li> Social Gathering (Pizza Party) </li>
                    <li> Casino Nights...</li>
                    <li> Game Night </li>
                    <li> Programming competition </li>
                    <li> etc.. </li>
                    </ol> ");
            echo ("<h3>Club officers:</h3>");
            echo ("Information about club officers and elections, terms, eligibility, etc.");
            echo ("<ul>
                    <li>Name, office held, email </li>
                    <li>Name, office held, email </li>
                    <li>Name, office held, email </li>
                    </ul>");
            echo ("</div>");
            echo ("<div id='reverse'> ");
            echo (" <h1>Questions and Comments: </h1>");
            echo ("<ul>
                    Questions about the about the Informatics Club should be directed to:<br />
                    Name <br />
                    email<br />
                    Department of Computer and Information Sciences <br />
                    Indiana University South Bend <br />
                    </ul>");
            echo ("</div>");
      
        }
        
        public function DisplayMembers()
        {
            echo ("<table border ='5' align='center'>");
            echo ("<thead>");
            echo ("<tr>");
            echo (" <th colspan='4' bgcolor='darkgrey'>");
            echo (" Informatics Club Membership");
            echo (" </th>");
            echo ("</tr>");
            echo ("<tr>");
            echo (" <th bgcolor='darkgrey'>");
            echo (" Name");
            echo (" </th>");
            echo (" <th bgcolor='darkgrey'> ");
            echo (" Email");
            echo (" </th>");
            echo (" <th bgcolor='darkgrey'> ");
            echo (" Gender");
            echo (" </th>");
            echo (" <th bgcolor='darkgrey' width='200px'>");
            echo (" Interests");
            echo (" </th>");
            echo ("</tr>");
            echo ("</thead>");
            echo ("<!-- The table Body -->");
            echo ("<tbody>");
            $Membership = $this->Get_Members_From_DB();
            for ($i = 0; $i < sizeof($Membership); $i++) {
                echo ("<tr>");
                echo (" <td>" . $Membership[$i]['FirstName'] . ", " . $Membership[$i]['LastName'] . "</td>");
                echo (" <td>" . $Membership[$i]['Email'] . "</td>");
                echo (" <td>" . $Membership[$i]['Gender'] . "</td>");
                $Interests = $this->Get_Members_Interests_From_DB($Membership[$i]['Email']);
                // Display the list of Interests
                echo (" <td>");
                for ($j = 0; $j < sizeof($Interests); $j++)
                    echo ("<li>" . $Interests[$j]['InterestDescription'] . "</li>");
                echo (" </td>");
                echo ("</tr>");
            }
            echo ("</body>");
            echo ("</table>");
        }

        function DisplayRegistrationForm()
        {
          //  $today = 1/1/2019;
            echo ("<form action= 'home_processform.php'
                    method='POST' >");
            echo ("<div id='RegistrationForm' ");
            echo (" style= 'background-color:lightgrey; ");
            echo (" border:2px solid black; ");
            echo (" border-radius: 10px;");
            echo (" height:500px; ");
            echo (" width:100%; ");
            echo (" float:left;'> ");
            echo (" <h1 align='center'>Become a Club Member</h1> ");
            echo (" <table style= 'margin:1cm;'> ");
            echo (" <tr> ");
            echo (" <td> <label> Your Email: </label> </td> ");
            echo (" <td> <input type='text' name='email' size='20' >
                    (must be unique)</td> ");
            echo (" </tr> ");
            echo (" <tr> ");
            echo (" <td> <label> First Name </label></td> ");
            echo (" <td> <input type='text' name='fname' size='20' ></td> ");
            echo (" </tr> ");
            echo (" <tr> ");
            echo (" <td> <label> Last Name </label></td> ");
            echo (" <td> <input type='text' name='lname' size='20' ></td> ");
            echo (" </tr> ");
            echo (" <tr> ");
            echo (" <td> Gender:</td> ");
            echo (" <td> ");
            echo (" <input type='radio' name='sex' value='Male'>Male<br> ");
            echo (" <input type='radio' name='sex' value='Female'>Female ");
            echo (" </td> ");
            echo (" </tr> ");
            echo (" <tr> ");
            echo (" <td> Interested in:</td> ");
            echo (" <td> ");
            echo (" <fieldset> ");
            echo (" <legend><b> Check all that apply: </b> </legend> ");
            $MemberInterests = $this->Get_Interests_Types_From_DB();
            for ($i = 0; $i < sizeof($MemberInterests); $i++) {
                $ID = $MemberInterests[$i]['InterestID'];
                $Description = $MemberInterests[$i]['InterestDescription'];
                echo ("<input type='checkbox'
                    name='interests[]'
                    value='$ID'>
                    $Description<br> ");
            }
            echo (" </fieldset> ");
            echo (" </td> ");
            echo (" </tr> ");
            echo (" </table> ");
            echo (" <p> </p> ");
            echo (" <center> ");
            echo (" <input type='image' ");
            echo (" src= '../images/signup.gif' ");
            echo (" height='45px' ");
            echo (" width ='90px' ");
            echo (" > ");
            echo (" </center> ");
            echo ("</div> ");
            echo ("</form> ");
        }

        function ProcessRegistrationForm()
        {
            if (!isset($_POST)) {
                echo ("Form was not completed");
            } else {
                // The post method is used
                echo ("<h3> Thank your for registering</h3>");
                $email = $_POST['email'];
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $sex = $_POST['sex'];
                // write to database
                $sql = "INSERT INTO member (Email, FirstName, LastName, Gender, MemberSince)
                        VALUES ('$email', '$fname', '$lname', '$sex', date('Y-m-d')); ";
                echo ($sql . "<br />");
                $status = mysqli_query($this->Con, $sql);
                if ($status == true) {
                    echo "Successful Registration <br />";
                    // Write the interests:
                    for ($i = 0; $i < sizeof($_POST['interests']); $i++) {
                        $interest = $_POST['interests'][$i];
                        $sql = "INSERT INTO member_interests (Email, InterestID)
                                VALUES ('$email', $interest); ";
                        echo ($sql . "<br />");
                        $result = mysqli_query($this->Con, $sql);
                    }
                } else {
                    echo "Error in Registration: " . mysqli_error($this->Con) . " <br />";
                }
            }

            echo("<a href='https:/sethi.sgedu.site/resources/home.php'>Go Back</a>");
        }
        
        public function Get_Members_From_DB()
        {
            $sql = "SELECT
                        member.Email,
                        member.FirstName,
                        member.LastName,
                        member.Gender,
                        member.MemberSince
                    FROM
                        member";
            $result = mysqli_query($this->Con, $sql);
            // print_r($result);
            $arrayResult = array();
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $arrayResult[] = $row;
                //print_r($row);
                //echo "<br />";
            }
            return ($arrayResult);
        }

        public function Get_Members_Interests_From_DB($MemberEmail)
        {
            $sql = "SELECT interest_type.InterestDescription
                    FROM member, member_interests, interest_type
                    WHERE member.Email = '$MemberEmail'
                    AND member.Email = member_interests.Email
                    AND member_interests.InterestID = interest_type.InterestID";
            $result = mysqli_query($this->Con, $sql);
            $arrayResult = array();
            while ($row = mysqli_fetch_array($result)) {
                $arrayResult[] = $row;
                //print_r($row);
                //echo "<br />";
            }
            return ($arrayResult);
        }

        private function Get_Interests_Types_From_DB()
        {
            $sql = "SELECT
                        InterestID,
                        InterestDescription
                    FROM
                        interest_type";
            $result = mysqli_query($this->Con, $sql);
            $arrayResult = array();
            while ($row = mysqli_fetch_array($result)) {
                $arrayResult[] = $row;
                //echo $row['InterestID'] . " " . $row['InterestDescription'];
                //echo "<br />";
            }
            return ($arrayResult);
        }
    }

//    $myClub = new Club("localhost", "A340User", "Pass123Word", "info_club");


?>