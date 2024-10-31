<style>
    .timeline div {
        padding: 0;
        height: 40px;
    }
    .timeline hr {
        border-top: 3px solid #5c6bc0;
        margin: 0;
        top: 17px;
        position: relative;
    }
    .timeline .col-2 {
        display: flex;
        overflow: hidden;
    }
    .timeline .corner {
        border: 3px solid #7986cb;
        width: 100%;
        position: relative;
        border-radius: 15px;
    }
    .timeline .top-right {
        left: 50%;
        top: -50%;
    }
    .timeline .left-bottom {
        left: -50%;
        top: calc(50% - 3px);
    }
    .timeline .top-left {
        left: -50%;
        top: -50%;
    }
    .timeline .right-bottom {
        left: 50%;
        top: calc(50% - 3px);
    }
    .circle {
        padding: 13px 20px;
        border-radius: 50%;
        background-color: #7986cb;
        color: #fff;
        max-height: 100px;
        z-index: 2;
    }
</style>

<div class="modal fade" id="work-timeline-modal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ประสบการณ์ทำงาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    <!--first section-->
                    <div class="row align-items-center how-it-works d-flex">
                        <div class="col-2 text-center bottom d-inline-flex justify-content-center align-items-center">
                            <div class="circle font-weight-bold">พ.ศ. 2565</div>
                        </div>
                        <div class="col-6">
                            <h5>10 พฤษภาคม พ.ศ. 2565</h5>
                            <p>นายแพทย์ ระดับเชี่ยวชาญ ที่โรงพยาบาลจักษุสุราษฎร์</p>
                        </div>
                    </div>
                    <!--path between left to right-->
                    <div class="row timeline">
                        <div class="col-2">
                            <div class="corner top-right"></div>
                        </div>
                        <div class="col-8">
                            <hr/>
                        </div>
                        <div class="col-2">
                            <div class="corner left-bottom"></div>
                        </div>
                    </div>
                    <!--second section-->
                    <div class="row align-items-center justify-content-end how-it-works d-flex">
                        <div class="col-6 text-end">
                            <h5>15 พฤษภาคม พ.ศ. 2555</h5>
                            <p>นายแพทย์ ระดับชำนาญการพิเศษ ที่โรงพยาบาลจักษุสุราษฎร์</p>
                        </div>
                            <div class="col-2 text-center full d-inline-flex justify-content-center align-items-center">
                            <div class="circle font-weight-bold">พ.ศ. 2555</div>
                        </div>
                    </div>
                    <!--path between right to left-->
                    <div class="row timeline">
                        <div class="col-2">
                            <div class="corner right-bottom"></div>
                        </div>
                        <div class="col-8">
                            <hr/>
                        </div>
                        <div class="col-2">
                            <div class="corner top-left"></div>
                        </div>
                    </div>
                    <!--third section-->
                    <div class="row align-items-center how-it-works d-flex">
                        <div class="col-2 text-center top d-inline-flex justify-content-center align-items-center">
                            <div class="circle font-weight-bold">พ.ศ. 2540</div>
                        </div>
                        <div class="col-6">
                            <h5>15 พฤษภาคม พ.ศ. 2540</h5>
                            <p>นายแพทย์ ระดับชำนาญการ ที่โรงพยาบาลจักษุสุราษฎร์</p>
                        </div>
                    </div>
                    <!--path between left to right-->
                    <div class="row timeline">
                        <div class="col-2">
                            <div class="corner top-right"></div>
                        </div>
                        <div class="col-8">
                            <hr/>
                        </div>
                        <div class="col-2">
                            <div class="corner left-bottom"></div>
                        </div>
                    </div>
                    <!--second section-->
                    <div class="row align-items-center justify-content-end how-it-works d-flex">
                        <div class="col-6 text-end">
                            <h5>15 พฤษภาคม พ.ศ. 2530</h5>
                            <p>นายแพทย์ ระดับปฏิบัติการ ที่โรงพยาบาลจักษุสุราษฎร์</p>
                        </div>
                            <div class="col-2 text-center full d-inline-flex justify-content-center align-items-center">
                            <div class="circle font-weight-bold">พ.ศ. 2530</div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>