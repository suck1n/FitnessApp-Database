<?php
    function get_tab(string $tableName, string $table_header, array $buttons = array()): string {
        $buttons = implode(", ", $buttons);

        $template = '<div class="w-100" id="table_container" role="tabpanel"">
                        <h1 id="table_name">%table%</h1>
                        <table id="table" class="table table-striped" style="width:100%" data-button="%buttons%" data-name="%table%">
                            <thead>
                                <tr id="columns">%header%</tr>
                            </thead>
                        </table>
                    </div>';

        $template = str_replace("%table%", ucfirst($tableName), $template);
        $template = str_replace("%header%", $table_header, $template);
        $template = str_replace("%buttons%", empty($buttons) ? "" : $buttons, $template);

        return $template;
    }