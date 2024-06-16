<div class="sidebar" id="sidebar">
    <div>
        <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li>
                    <a href="/ENSAHify/views/chef_dep/home.php"><i class="fas fa-home"></i><span> Home</span></a>
                </li>
                <li>
                    <a href="/ENSAHify/views/chef_dep/teacher-management/view_teacher.php"><i class="fas fa-chalkboard-teacher"></i><span> Teachers</span></a>
                </li>
                <li>
                    <a href="/ENSAHify/views/chef_dep/module-management/view_module.php"><i class="fas fa-book-reader"></i><span> Modules</span></a>
                </li>
                <?php  if ($_SESSION['user_data']['role'] == 1) { ?>
                <li class="menu-title">
                    <span>Profesor Menu</span>
                </li>
                <li>
                    <a href="/ENSAHify/views/professeur/choixModuleCours.php"><i class="fas fa-book"></i> <span> Cours</span></a>
                </li>
                <li>
                    <a href="/ENSAHify/views/professeur/module-view.php"><i class="fas fa-book-reader"></i><span> Modules List</span></a>
                </li>
                <li>
                    <a href="/ENSAHify/views/professeur/choixModuleNotes.php"><i class="fas fa-clipboard"></i> <span> Grades</span></a>
                </li>
                <li>
                    <a href="/ENSAHify/views/professeur/timetable.php"><i class="fas fa-calendar-day"></i> <span> Times Table</span></a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-address-card"></i><span> Profile</span></a>
                </li>
            <?php }?>
            </ul>
        </div>
    </div>
</div>

        