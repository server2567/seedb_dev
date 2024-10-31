<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav1" data-bs-toggle="collapse" href="#">
          <i class="bi-window-dock"></i><span>ระบบ - เมนู</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav1" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowSystem">
              <i class="bi bi-circle"></i><span>ข้อมูลระบบ - เมนู</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowWorkGroup">
              <i class="bi bi-circle"></i><span>ข้อมูลกลุ่มระบบงาน - กำหนดสิทธิ์</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowQuestion">
              <i class="bi bi-circle"></i><span>ข้อมูลคำถามส่วนตัว</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowUserGroup">
              <i class="bi bi-circle"></i><span>ข้อมูลกลุ่มผู้ใช้</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav2" data-bs-toggle="collapse" href="#">
          <i class="bi-file-earmark-person"></i><span>ข้อมูลผู้ใช้</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav2" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowUser/edit">
              <i class="bi bi-circle"></i><span>เพิ่มข้อมูลผู้ใช้งาน</span>
            </a>
          </li>
          <li> 
            <a href="<?php echo base_url()?>index.php/UMS/ShowUser/">
              <i class="bi bi-circle"></i><span>ข้อมูลผู้ใช้งานระบบ - กำหนดสิทธิ์</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/syncHRsingle">
              <i class="bi bi-circle"></i><span>นำเข้าข้อมูลบุคลากร</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/UMS">
              <i class="bi bi-circle"></i><span>จัดการสิทธิ์รายกลุ่ม</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav3" data-bs-toggle="collapse" href="#">
          <i class="bi-search"></i><span>รายงาน</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav3" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowReport/reportPermission">
              <i class="bi bi-circle"></i><span>รายงานการกำหนดสิทธิ์เข้าใช้งาน</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowReport/reportUser">
              <i class="bi bi-circle"></i><span>รายงานสถิติของระบบ</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowReport/reportEditpermission">
              <i class="bi bi-circle"></i><span>ประวัติการเพิ่มลดสิทธิ์ผู้ใช้</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowReport/showLog">
              <i class="bi bi-circle"></i><span>รายงานการเข้าใช้งานระบบ</span>
            </a>
          </li>
          <!-- <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowReport">
              <i class="bi bi-circle"></i><span>ประวัติการใช้งาน</span>
            </a>
          </li> -->
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav4" data-bs-toggle="collapse" href="#">
          <i class="bi-gear-fill"></i><span>จัดการไอคอนระบบ</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav4" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/ShowIcon">
              <i class="bi bi-circle"></i><span>อัพโหลดไอคอน</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/UMS">
              <i class="bi bi-circle"></i><span>จัดการรูปแบบของระบบ</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav5" data-bs-toggle="collapse" href="#">
          <i class="bi-files"></i><span>คัดลอกเมนูระบบ</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav5" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/CopySystemmenu/importSystemmenu">
              <i class="bi bi-circle"></i><span>นำเข้าเมนูระบบ</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url()?>index.php/UMS/CopySystemmenu">
              <i class="bi bi-circle"></i><span>ส่งออกเมนูระบบ</span>
            </a>
          </li>
        </ul>
      </li>
  </ul>
</aside><!-- End Sidebar-->