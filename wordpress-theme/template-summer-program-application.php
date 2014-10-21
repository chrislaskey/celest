<?php
/**
 * Template Name: Summer Program Application
 *
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */
?><?php include(TEMPLATEPATH.'/header.php'); ?>

    <section id="main" class="container clearfix">

        <section id="sidebar" class="five columns alpha">

            <?php include(TEMPLATEPATH.'/sidebar.php'); ?>

        </section>

        <section id="content-container" class="eleven columns omega">

            <?php the_post(); ?>

            <section id="content" <?php post_class('page'); ?>>

                <h1 class="title page_title"><?php the_title(); ?></h1>

                <div class="post_content">

                    <?php the_content(); ?>

                    <div id="message-container"></div>

                    <form action="#" class="input summer_program_application" method="post">

                        <h4>Personal Information</h4>
                        <table cellpadding="0" cellspacing="0" class="application">
                            <tbody>
                                <tr>
                                    <td class="key">
                                        <label for="first_name">First Name</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="first_name" name="first_name" placeholder="First Name" type="text"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="last_name">Last Name</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="last_name" name="last_name" placeholder="Last Name" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="date_of_birth">Date of Birth</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="date_of_birth" name="date_of_birth" placeholder="mm/dd/yyyy" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="current_location">Current City and State</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="current_location" name="current_location" placeholder="City, State" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="permanent_location">Permanent City and State</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="permanent_location" name="permanent_location" placeholder="City, State" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="gender">Gender</label>
                                    </td>
                                    <td class="value">
                                        <select id="gender" name="gender">
                                            <option value="">&nbsp;</option>
                                            <option value="Female">Female</option>
                                            <option value="Male">Male</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="ethnicity">Ethnicity</label>
                                    </td>
                                    <td class="value">
                                        <select id="ethnicity" name="ethnicity">
                                            <option value="">&nbsp;</option>
                                            <option value="African-American/Black">African-American/Black</option>
                                            <option value="Asian">Asian</option>
                                            <option value="Caucasian/White">Caucasian/White</option>
                                            <option value="Hispanic/Latino">Hispanic/Latino</option>
                                            <option value="Native American">Native American</option>
                                            <option value="Pacific Islander or Native Hawaiian">Pacific Islander or Native Hawaiian</option>
                                            <option value="Other">Other</option>
                                            <option value="Decline to Answer">Decline to Answer</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="resident_status">Resident Status</label>
                                    </td>
                                    <td class="value">
                                        <select id="resident_status" name="resident_status">
                                            <option value="">&nbsp;</option>
                                            <option value="U.S. Citizen">U.S. Citizen</option>
                                            <option value="U.S. Permanent Resident">U.S. Permanent Resident</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="phone_primary">Primary Phone</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="phone_primary" name="phone_primary" placeholder="Primary Phone" type="phone" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="phone_secondary">Secondary Phone*</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="phone_secondary" name="phone_secondary" placeholder="Secondary Phone" type="phone" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="email">Email Address</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="email" name="email" placeholder="Email" type="email" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="email_verify">Verify Email Address</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="email_verify" name="email_verify" placeholder="Verify Email" type="email" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4>Academic Information</h4>
                        <table cellpadding="0" cellspacing="0" class="application">
                            <tbody>
                                <tr>
                                    <td class="key">
                                        <label for="institution">Current Institution</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="institution" name="institution" placeholder="Current Institution" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="major">Current Major</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="major" name="major" placeholder="Current Major" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="gpa">Cumulative GPA</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="gpa" name="gpa" placeholder="Cumulative GPA" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="graduation_date">Expected Graduation Date</label>
                                    </td>
                                    <td class="value">
                                        <input class="text" id="graduation_date" name="graduation_date" placeholder="Expected Graduation Date" type="text" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="post_graduation">Post Graduation Plans</label>
                                    </td>
                                    <td class="value">
                                        <select id="post_graduation" name="post_graduation">
                                            <option value="">&nbsp;</option>
                                            <option value="Graduate School">Graduate School</option>
                                            <option value="Industry">Industry</option>
                                            <option value="Medical School">Medical School</option>
                                            <option value="Other">Other</option>
                                            <option value="Undecided">Undecided</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4>Post Graduation</h4>
                        <p>Please explain in approximately 300&ndash;500 words your current post graduation plans.</p>
                        <table cellpadding="0" cellspacing="0" class="application">
                            <tbody>
                                <tr>
                                    <td class="full">
                                        <textarea class="text text_half" id="essay" name="post_graduation_essay"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4>Summer Program Information</h4>
                        <p>For more information on participating faculty please see the <a class="external" href="/events-and-programs/summer-program/faculty-mentors-2015/">Faculty Mentors</a> page.</p>

                        <?php $mentors = get_api_data('/api/our-people/groups/summer-program-2015'); ?>

                        <table cellpadding="0" cellspacing="0" class="application">
                            <tbody>
                                <tr>
                                    <td class="key">
                                        <label for="mentor_first">First Choice Mentor</label>
                                    </td>
                                    <td class="value">
                                        <select id="mentor_first" name="mentor_first">
                                            <option value="">&nbsp;</option>
                                            <?php
                                                foreach($mentors->users as $user){
                                                    echo '<option value="'.$user->slug.'">'.$user->screen_name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="mentor_second">Second Choice Mentor*</label>
                                    </td>
                                    <td class="value">
                                        <select id="mentor_second" name="mentor_second">
                                            <option value="">&nbsp;</option>
                                            <?php
                                                foreach($mentors->users as $user){
                                                    echo '<option value="'.$user->slug.'">'.$user->screen_name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="mentor_third">Third Choice Mentor*</label>
                                    </td>
                                    <td class="value">
                                        <select id="mentor_third" name="mentor_third">
                                            <option value="">&nbsp;</option>
                                            <?php
                                                foreach($mentors->users as $user){
                                                    echo '<option value="'.$user->slug.'">'.$user->screen_name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4>Application Essay</h4>
                        <p>Please explain in approximately 500&ndash;1000 words why you would like to participate in the program.</p>
                        <table cellpadding="0" cellspacing="0" class="application">
                            <tbody>
                                <tr>
                                    <td class="full">
                                        <textarea class="text" id="essay" name="essay"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table cellpadding="0" cellspacing="0" class="application">
                            <tbody>
                                <tr>
                                    <td class="full">
                                        <input class="hidden" name="year" type="hidden" value="2015"/>
                                        <input class="submit" name="submit" type="submit" value="Submit"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </form>

                    <script>

                        $(document).ready(function(){

                            var summer = {};

                            summer.url = '/api/summer-program/application';
                            summer.form = $('form.summer_program_application');
                            summer.messages = Messenger('#message-container');

                            summer.form.on('submit', function(e){

                                $.ajax({
                                    type: "POST",
                                    url: summer.url,
                                    data: summer.form.serialize(),
                                    success: function(data){
                                        var result = $.parseJSON(data);
                                        summer.messages.show(result.status, result.message);
                                        if( result.status == 'success' ){
                                            summer.form.hide();
                                        }
                                        scrollToAnchor('online-application');
                                    }
                                });

                                e.preventDefault();

                            });

                            function Messenger(container_target){
    
                                var container = $(container_target);

                                function show_message(type, text){
                                    var message = '<blockquote class="message message-type-' + type + '">' + text + '</blockquote>';
                                    container.html(message) 
                                }
                                
                                return {
                                    show: function(type, text){
                                       return show_message(type, text);
                                    }
                                }

                            };

                            function scrollToAnchor(aid){

                                var aTag = $("a[name='"+ aid +"']");

                                $('html,body').animate({scrollTop: aTag.offset().top},'slow');

                            };

                        });

                    </script>

                </div>

            </section>

        </section>

    </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
