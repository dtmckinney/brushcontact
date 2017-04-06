<? include("header.php"); ?>

    <body>

        <div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Private Room</h4>
                    </div>
                    <div class="modal-body">
                        <p>Create New Room Key (Password)</p>
                        <p>
                            <form action="create_rm.php" name="createkeyform" method="post">
                                <input class="form-control" type="text" id="rm-key" name="rm-key" placeholder="e.g. x86Nb5tFK" />
                                <input class="btn btn-primary" type="submit" name="submit" value="Create" />
                            </form>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="myModal2" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">View Private Room</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter Room Key</p>
                        <p>
                            <form name="checkkeyform" method="post">
                                <input class="form-control" type="text" id="rmkey" name="rmkey" placeholder="" value="" />
                                <input class="btn btn-primary" id="checkrmkey" type="submit" name="submit" value="Go" />
                            </form>
                        </p>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <div id="myModal3" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Everything?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Choosing OK will delete EVERYTHING in this room, and CANNOT be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="del-ok" data-dismiss="modal">OK</button>
                        <button type="button" class="btn btn-default" id="del-no" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="myModal4" class="modal fade myModal4" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Preview</h4>
                    </div>
                    <div class="modal-body">
                        <p><img class="passed_image" src="" width="100%" /></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="row row-top">
                <div class="col-xs-12">
                    <div id="header">
                        <span id="letter_b">Brush</span>
                        <span id="letter_c">Contact</span>
                    </div>
                    <div id="subheader">For quick exchanges of words and files between strangers</div>
                    <div id="header-url"><a id="urlout" href="" target="_blank">URL</a></div>
                    <div id="burnit-header">Time 'til Burn
                        <br> (CLICK/TAP)</div>
                    <div id="timer-output"></div>

                    <div class="key" id="key">
                        <i class="fa fa-key" aria-hidden="true"></i>
                    </div>
                </div>

            </div>

            <div class="row row-top">

                <div class="col-sm-12">
                    <div id="textblock_output"></div>
                    <br>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="shareheader" id="shareheader-text">Share Message</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div id="textblock">
                        <textarea class="form-control" cols="30" id="text-block" rows="2" name="text-block"></textarea>
                    </div>
                    <div class="buttonwrapper row">
                        <div class="col-xs-10">
                            <input class="btn btn-primary textblockbutton" disabled="disabled" type="button" value="Send" />
                        </div>
                        <div class="col-xs-2">
                            <div class="trash-all" id="trash-all-text"><i class="fa fa-trash" aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row hidden">

                <div class="col-sm-12">
                    <div class="shareheader" id="shareheader-links">Share Link</div>
                    <div class="trash-all" id="trash-all-links"><i class="fa fa-trash" aria-hidden="true"></i></div>
                    <div id="linkblock">
                        <input class="form-control" type="text" disabled="disabled" id="link-block" name="link-block" />
                    </div>
                    <div class="buttonwrapper">
                        <input class="btn btn-primary linkblockbutton" disabled="disabled" type="button" value="Send" />
                    </div>
                    <br>
                    <div id="linkblock_output"></div>
                </div>

            </div>

            <br>

            <div class="row">
                <div class="col-sm-12">
                    <div class="shareheader" id="shareheader-images">Share File</div>
                </div>
            </div>
            <div class="row">
                <form id="uploadfile" name="form" method="post" enctype="multipart/form-data">
                    <div class="col-sm-8">
                        <div id="pathblock">
                            <input type="hidden" name="rm" id="rm" value="" />
                            <input class="form-control path-block" type="file" value="Upload" disabled="disabled" id="file" name="file[]" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="buttonwrapper">
                            <input class="btn btn-primary fileblockbutton" type="submit" name="submit" value="Send" />
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="pathblock_wrapper">
                        <div id="pathblock_output"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="footerlink">
                        <div id="out"></div>
                        <a href="<? echo $root_path ?>" target="_blank">Home</a>

                        <div class="bc_defined">
                            <p><strong>Brush Contact:</strong> <em>a brief encounter between friendly spies to share a few words or documents.</em></p>
                        </div>
                        <?php /*?>
                            <div><a href="http://derekt.me" target="_blank">DerekT.Me</a></div>
                            <?php */?>
                    </div>
                </div>
            </div>

        </div>

    </body>

    </html>