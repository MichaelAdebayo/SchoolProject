<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta
            name="description"
            content="Main Landing Page of the Dashboard of Longworth Dental Boutique" />
        <link rel="stylesheet" href="styles/numberPage.css" />
        <link rel="stylesheet" href="styles/style.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap"
            rel="stylesheet" />
        <script
            src="https://kit.fontawesome.com/170f096220.js"
            crossorigin="anonymous"></script>

        <script src="script/main.js" type="text/javascript"></script>

        <link
            href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"
            rel="stylesheet" />
        <title>Numbers | Story</title>
    </head>
    <body>
        
            <div class="sideBarNav">
            <div class="company-details">
                <div class="companyName">
                    <i class="fa-solid fa-book-open-reader"></i>Story
                </div>
            </div>
            <ul class="sideNavList">
                <li>
                    <a href="#">
                        <i class="fas fa-th-large"></i>
                        <span class="linksName">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-sharp fa-solid fa-calendar-days"></i>
                        <span class="linksName">TimeSheet</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span class="linksName">Analytics</span>
                    </a>
                </li>
                <li>
                
                        <a
                            href="#"
                            class="NumbersButton"
                            onclick="settingHoverNumbers()">
                            <i class="fa fa-caret-down"></i
                            ><span class="linksName">Numbers</span>
                        </a>
                        <div class="dropNumbers" id="dropNumbers">
                            <a href="#"
                                ><i class="fa-sharp fa-solid fa-circle-small"></i><span class="linksName">Dr. Barr, Sharon</span></a
                            >
                            <a href="#"
                                ><i class="fa-sharp fa-solid fa-circle-small"></i><span class="linksName">Dr. Ismail, Ahmed</span></a
                            >
                            <a href="#"
                                ><i class="fa-sharp fa-solid fa-circle-small"></i><span class="linksName">Boisret, Cassidy</span></a
                            >
                        </div>
                    
                </li>
                <li class="profile">
                    <div class="profileInfo">
                        <!--<img src="profile.jpg" alt="profileImg">-->
                        <div class="name_position">
                            <div class="name">Name</div>
                            <div class="position">Receptionist</div>
                        </div>
                        <a href="logout.php"
                            ><i
                                class="fa-sharp fa-solid fa-arrow-right-from-bracket"
                                id="log_out"></i
                        ></a>
                    </div>
                </li>
            </ul>
        </div>
      
            <!-- Main Page Contents -->
            <section class="homeContent">
          
                    <!-- User Profile Dropdown -->
                    <div class="dataActions">
                        <a href="#"
                            ><i class="fa-solid fa-circle-plus"></i> Add
                            Day-End</a
                        >
                        <a href="#"
                            ><i class="fa-solid fa-cloud-arrow-up"></i> Database
                            Import</a
                        >
                        <a href="#"
                            ><i class="fa-solid fa-file-import"></i> File
                            Import</a
                        >
                        <a href="#"
                            ><i class="fa-solid fa-pen-to-square"></i> Edit</a
                        >
                    </div>
            
                <div class="numbersTable">
                    <table class="dataSheet">
                        <tr>
                            <th>
                                <input type="checkbox" />
                            </th>
                            <th>DATE<i class="fa fa-caret-down"></i></th>
                            <th>AVAILABLE HOURS</th>
                            <th>DOWNTIME HOURS</th>
                            <th>GROSS PRODUCTION</th>
                            <th>MEMO</th>
                        </tr>
                        <tr class="Row">
                            <td><input type="checkbox" /></td>
                            <td>22-10-2020</td>
                            <td>5</td>
                            <td>2</td>
                            <td>5</td>
                            <td></td>
                        </tr>
                        <tr class="Row">
                            <td><input type="checkbox" /></td>
                            <td>22-10-2022</td>
                            <td>4</td>
                            <td>2</td>
                            <td>5</td>
                            <td></td>
                        </tr>
                        <tr class="Row">
                            <td><input type="checkbox" /></td>
                            <td>22-10-2022</td>
                            <td>4</td>
                            <td>2</td>
                            <td>5</td>
                            <td></td>
                        </tr>
                        <tr class="Row">
                            <td><input type="checkbox" /></td>
                            <td>22-10-2022</td>
                            <td>4</td>
                            <td>2</td>
                            <td>5</td>
                            <td></td>
                        </tr>
                        <tr class="Row">
                            <td><input type="checkbox" /></td>
                            <td>22-10-2022</td>
                            <td>4</td>
                            <td>2</td>
                            <td>5</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </section>
     
        <footer></footer>
    </body>
</html>
