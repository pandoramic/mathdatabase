<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Math Problem Bank</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        window.MathJax = {
            tex2jax: {
                inlineMath: [["\\(", "\\)"]],
                processEscapes: true
            }
        };
    </script>
    <script type="text/javascript"
            src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
    </script>
            <?php require('math.php'); ?>
    <script type="text/javascript">
        <!--
            function add(obj) {
                $(obj).parents(".form").find(".edit").toggle();
                if($(obj).val() === "Add New") {
                    $(obj).val("Cancel");
                } else  {
                    $(obj).val("Add New");
                }
            }

            function update(obj) {
                // Update buttons to edit mode, including save and cancel
                // Hide/Show save button
                $(obj).siblings(".saveButtons").toggle();
                // While adding categories, hide sort button to make room for save button
                $(obj).siblings(".sort").toggle();
                // Set button to edit or save, whichever is opposite of what it was when clicked
                if($(obj).val() === "Edit")  {
                    $(obj).val("Cancel");
                } else    {
                    $(obj).val("Edit");
                }
                // Toggle visiblity of problem text boxes to reveal or hide editing box
                $(obj).parents(".form").find(".editBox").toggle();
                $(obj).parents(".form").find(".finishedPrint").toggle();
                // Disable all other buttons while in edit mode, then re-enable when edit mode is exited
                // Object value will be "Cancel" while in edit mode since it was reset above to show cancel button
                var buttons = document.getElementsByTagName("input");
                if($(obj).val() === "Cancel") {
                    for (var i = 0; i < buttons.length; i++) {
                        if (buttons[i].type === "button" || buttons[i].type == "submit") {
                            buttons[i].disabled = true;
                            $(obj).removeAttr("disabled");
                            $(obj).siblings(".saveButtons").removeAttr("disabled");
                        }
                    }
                } else  {
                    for (var i = 0; i < buttons.length; i++) {
                        if (buttons[i].type === "button" || buttons[i].type == "submit") {
                            buttons[i].disabled = false;
                        }
                    }
                }
            }
        //    -->
    </script>
</head>
<body style="background-color: #f1f1f1;">
    <div id="masthead">
        <div class="container outer">
            <div class="row inner">
<!-- Buttons and form for adding new questions to database -->
                <form action="index.php" id="problem" name="problem" class="form" method="post">
                    <div class="col-md-3" id="problem" onclick="location.href='index.php';" style="cursor: pointer;">
                        <h1>Math Problem Bank</h1>
                    </div>
                    <br/>
                    <div class="col-md-2">
                        <input type="button" id="problemAdd" name="problemAdd" class="default btn-block" value="Add New" onclick="add(this)" />
                        <br/>
                        <input type="submit" id="submit" class="edit btn-block" value="Submit Problem" style="display:none;" />
                    </div>
                    <div class="col-md-6">
                        <textarea rows="5" id="problem" name="problem" class="edit form-control" style="display: none;"></textarea>
                    </div>
                    <div class="col-md-1"></div>
                </form>
            </div>
        </div>
    </div>
<!-- Display categories and buttons to edit them -->
        <div class="row">
            <nav class="col-md-3">
                <ul class="nav nav-stacked nav-pills" data-spy="affix" data-offset-top="205">
                    <p> Categories </p>
                        <?php
                            $rowC = count($catIdArr);
                        for ($i = 0; $i < count($catIdArr); $i++) {
                            ?>
                            <div class="row">
                                <form action="index.php" class="form" method="post">
                                    <li>
                                        <div class="col-md-7">
                                            <input type="text" name="cat" id="cat" class="editBox form-control" value="<?php print htmlentities($catNameArr[$i]); ?>" style="display: none;" />
                                            <div id="categories" class="finishedPrint"> <?php print $catNameArr[$i]; ?> </div>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="button" id="edit" name="edit" class="editButtons btn-sml" value="Edit" onclick="update(this)"/>
                                            <input type="hidden" id="idCategory" name="idCategory" value="<?php print $rowC ?>"/>
                                            <input type="submit" id="sort" name="sort" class="sort btn-sml" value="Select All">
                                            <input type="submit" id="save" name="save" class="saveButtons btn-sml" value="Save" style="display: none;"/>
                                        </div>
                                    </li>
                                </form>
                            </div>
                        <?php $rowC--; } ?>
    <!-- Buttons and form for adding new categories to database -->
                    <form action="index.php" id="category" name="category" class="form" method="post">
                        <input type="text" id="categoryVal" name="categoryVal" class="edit form-control" style="display:none;"/>
                        <input type="button" id="categoryAdd" name="categoryAdd" class="default btn-block" value="Add New" onclick="add(this)"/>
                        <input type="submit" id="submitCat" class="edit btn-block" value="Submit Category" style="display:none;"/>
                    </form>
                    <br/>
                </ul>
            </nav>
    <!-- Database display, including editing existing and sorting into categories -->
            <div class="col-md-9"  id="mainCol">
    <!-- Display table of problems stored in database, along with buttons to edit them -->
                        <?php
                        for ($i = 0; $i < count($probIdArr); $i++) {
                            $rowP = (int)$probIdArr[$i];
                            ?>
                <div class="row dataLine">
                    <div class="col-md-1">
                        <?php print $probIdArr[$i]; ?>
                    </div>
                    <form action="index.php" class="form" method="post">
                        <div class="col-md-6">
                            <input type="text" name="prob" id="prob" class="editBox form-control" value='<?php print htmlentities($probContArr[$i]); ?>' style="display: none;" />
                            <div id="problems" class="finishedPrint"> <?php print $probContArr[$i]; ?> </div>
                        </div>
                        <div class="col-md-1">
                            <input type="button" id="edit" name="edit" class="editButtons btn-block" value="Edit" onclick='update(this)'/>
                            <input type="submit" id="save" name="save" class="saveButtons btn-block" value="Save" style="display: none;"/>
                            <input type="hidden" id="idProblem" name="idProblem" value='<?php print $rowP ?>'/>
                        </div>
                    </form>
                    <div class="col-md-2 dropdown">
                        <form action="index.php" name="dropForm" class="form" method="post">
                            <input type="submit" class="btn-block" value="Connect"/>
                            <input type="hidden" id="dropProbId" name="dropProbId" value="<?php print $rowP ?>"/>
                            <select id="dropCatId" name="dropCatId" class="dropdown-toggle" data-toggle="dropdown">Choose Category
                                <span class="caret"></span>
                                <option id="catSelect" class="catSelect" value="">Choose a Category</option>
                                <?php
                                    $rowD = count($catIdArr);
                                for ($j = 0; $j < count($catIdArr); $j++) {
                                    ?>
                                    <option id="catSelect" class="catSelect" value="<?php print $rowD; ?>"> <?php print htmlentities($catNameArr[$j]); ?> </option>
                                    <?php
                                    $rowD--;
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <?php
                        $query = "SELECT name FROM category, prob_cat_mapping WHERE problem_id='$rowP' AND cid=category_id";
                        $res = mysqli_query($con, $query);
                        if($res != null) {
                            while ($rows = mysqli_fetch_assoc($res)) {
                                print "> " . $rows['name'];
                                ?> <br/> <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                        <?php
                            $rowP--;
                        }
                        mysqli_close($con);
                        ?>
            </div>
        </div>
    </div>
</body>
</html>