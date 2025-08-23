<?php include 'include/header.php'; ?>
<style>
    main{
        margin-top: 0px!important;
        padding-top: 50px!important;
    }
  .erp-hero{
    max-width: 980px;
    text-align: center;
    padding: 48px 28px;
    border-radius: 24px;
    background: linear-gradient(135deg,#f4f7ff, #eef9ff);
    box-shadow: 0 10px 30px rgba(28, 77, 255, 0.08);
    position: relative;
    overflow: hidden;
  }
  .erp-hero::before{
    content:"";
    position:absolute; top:-80px; right:-80px;
    width:220px; height:220px; border-radius:50%;
    background: radial-gradient(#e6f0ff, transparent 60%);
    filter: blur(2px);
  }
  .erp-badge{
    display:inline-flex; gap:10px; align-items:center;
    font-weight:600; letter-spacing:.4px;
    padding:8px 14px; border-radius:999px;
    background:#fff; color:#1f4cff; border:1px solid #e6ebff;
    box-shadow: 0 4px 12px rgba(31,76,255,.08);
    margin-bottom:16px;
  }
  .erp-badge i{ font-size:16px; }
  .erp-title{
    font-weight:800; font-size:clamp(26px, 4vw, 44px);
    margin:0 0 12px; color:#0f172a;
  }
  .erp-title span{ color:#1f4cff; }
  .erp-subtitle{
    color:#475569; font-size:clamp(14px, 2.2vw, 18px);
    max-width:760px; margin:0 auto 22px; line-height:1.6;
  }
  .erp-chips{
    display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin-bottom:22px;
  }
  .erp-chips span{
    background:#ffffff; border:1px solid #e6ebff; color:#334155;
    padding:8px 12px; border-radius:999px; font-weight:600;
    display:inline-flex; align-items:center; gap:8px;
  }
  .erp-actions .btn{
    padding:10px 20px; border-radius:12px; font-weight:700; margin:6px;
  }
  .erp-actions .btn-primary{
    background:#1f4cff; border-color:#1f4cff;
  }
  .erp-actions .btn-outline-primary{
    border-color:#1f4cff; color:#1f4cff; background:#fff;
  }
  .erp-face-lock{
    margin-top:18px; font-size:14px; color:#475569; opacity:.9;
    display:inline-flex; gap:8px; align-items:center;
    padding:8px 12px; border-radius:10px; background:#ffffffbf; border:1px dashed #c7d2fe;
  }
</style>


<main>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Paste inside: <div class="col-12"> ... </div> -->
                        <div class="erp-hero mx-auto">
                        <h1 class="erp-title">
                            Welcome to <span>RN Mission School</span>
                        </h1>

                        <div class="erp-badge">
                            <i class="fas fa-school"></i>
                            ERP School Software
                        </div>

                        <p class="erp-subtitle">
                            Manage admissions, attendance, exams, fees & reports — sab kuch ek hi place par.
                            Fast, secure, aur easy-to-use dashboard ke saath aapki school operations super smooth.
                        </p>

                        <div class="erp-chips">
                            <span><i class="fas fa-user-check"></i> Attendance</span>
                            <span><i class="fas fa-receipt"></i> Billing & Fees</span>
                            <span><i class="fas fa-book"></i> Exams</span>
                            <span><i class="fas fa-chart-line"></i> Reports</span>
                        </div>

                        <div class="erp-actions">
                            <a href="login" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </div>

                        <!-- Future: Face Lock placeholder -->
                        <div class="erp-face-lock">
                            <i class="fas fa-user-lock"></i>
                            Face Lock (Coming Soon)
                        </div>
                        </div>

                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'include/footer.php'; ?>