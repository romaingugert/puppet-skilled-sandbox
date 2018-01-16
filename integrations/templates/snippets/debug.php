<div class="debug">
    <input type="checkbox" id="debug">
    <label for="debug" class="debug-toggle"></label>
    <div class="debug-wrap">
        <ul class="debug-bar">
            <li class="debug-dropdown">
                <b>0.0432</b>
                <ul class="debug-dropdown-content">
                    <li><span><b>Loading Time: Base Classes:</b><br>0.0058</span></li>
                    <li><span><b>Controller Execution Time ( Notification / Index ):</b><br>0.0058</span></li>
                    <li><span><b>Total Execution Time:</b><br>0.0267</span></li>
                </ul>
            </li>
            <li class="debug-dropdown">
                <b>5,561,048</b> bytes
                <ul class="debug-dropdown-content">
                    <li><a href="#debug-post-data">POST data</a></li>
                    <li><a href="#debug-get-data">GET data</a></li>
                    <li><a href="#debug-headers">HTTP headers</a></li>
                </ul>
            </li>
            <li class="debug-dropdown"><b>5,561,048</b> bytes</li>
            <li class="debug-dropdown"><b>5,561,048</b> bytes</li>
            <li class="debug-dropdown"><b>5,561,048</b> bytes</li>
            <li class="debug-dropdown"><b>5,561,048</b> bytes</li>
        </ul>
        <div class="debug-window" id="debug-post-data">
            <a href="#" class="debug-window-close">&times;</a>
            Hey
        </div>
        <div class="debug-window" id="debug-get-data">
            <a href="#" class="debug-window-close">&times;</a>
            <pre><?php print_r($_GET) ?></pre>
        </div>
        <div class="debug-window" id="debug-headers">
            <a href="#" class="debug-window-close">×</a>
            <h2 class="debug-window-title">EN-TETES HTTP</h2>
            <table>
                <tbody><tr>
                    <td>HTTP_ACCEPT</td>
                    <td>
                        text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8            </td>
                </tr>
                        <tr>
                    <td>HTTP_USER_AGENT</td>
                    <td>
                        Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36            </td>
                </tr>
                        <tr>
                    <td>HTTP_CONNECTION</td>
                    <td>
                        keep-alive            </td>
                </tr>
                        <tr>
                    <td>SERVER_PORT</td>
                    <td>
                        80            </td>
                </tr>
                        <tr>
                    <td>SERVER_NAME</td>
                    <td>
                        192.168.1.100            </td>
                </tr>
                        <tr>
                    <td>REMOTE_ADDR</td>
                    <td>
                        192.168.1.100            </td>
                </tr>
                        <tr>
                    <td>SERVER_SOFTWARE</td>
                    <td>
                        Apache/2.4.23 (Unix) PHP/7.0.12            </td>
                </tr>
                        <tr>
                    <td>HTTP_ACCEPT_LANGUAGE</td>
                    <td>
                        en-US,en;q=0.8,fr;q=0.6            </td>
                </tr>
                        <tr>
                    <td>SCRIPT_NAME</td>
                    <td>
                        /puppet_skilled/index.php            </td>
                </tr>
                        <tr>
                    <td>REQUEST_METHOD</td>
                    <td>
                        GET            </td>
                </tr>
                        <tr>
                    <td> HTTP_HOST</td>
                    <td>
                                    </td>
                </tr>
                        <tr>
                    <td>REMOTE_HOST</td>
                    <td>
                                    </td>
                </tr>
                        <tr>
                    <td>CONTENT_TYPE</td>
                    <td>
                                    </td>
                </tr>
                        <tr>
                    <td>SERVER_PROTOCOL</td>
                    <td>
                        HTTP/1.1            </td>
                </tr>
                        <tr>
                    <td>QUERY_STRING</td>
                    <td>
                        search=us&amp;action=filter            </td>
                </tr>
                        <tr>
                    <td>HTTP_ACCEPT_ENCODING</td>
                    <td>
                        gzip, deflate, sdch            </td>
                </tr>
                        <tr>
                    <td>HTTP_X_FORWARDED_FOR</td>
                    <td>
                                    </td>
                </tr>
                        <tr>
                    <td>HTTP_DNT</td>
                    <td>
                                    </td>
                </tr>
                <tr>
                    <td>Code sample</td>
                    <td class="debug-highlight">
                        <code><span style="color: #000000">
                        <span style="color: #0000BB">select&nbsp;</span><span style="color: #007700">`</span><span style="color: #DD0000">timestamp</span><span style="color: #007700">`,&nbsp;`</span><span style="color: #DD0000">data</span><span style="color: #007700">`&nbsp;</span><span style="color: #0000BB">from&nbsp;</span><span style="color: #007700">`</span><span style="color: #DD0000">core_sessions</span><span style="color: #007700">`&nbsp;</span><span style="color: #0000BB">where&nbsp;</span><span style="color: #007700">`</span><span style="color: #DD0000">id</span><span style="color: #007700">`&nbsp;=&nbsp;</span><span style="color: #DD0000">'uapjqgnjn1tbnfik0u2pep6j2cbusri6'&nbsp;</span><span style="color: #0000BB">limit&nbsp;1&nbsp;</span>
                        </span>
                        </code>
                    </td>
                </tr>
                    </tbody></table>
        </div>
    </div>
</div>
