<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Luna Health - Therapist Dashboard</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <!-- Navigation -->
    <nav
      class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top"
    >
      <div class="container-fluid px-4">
        <a class="navbar-brand" href="#">
          <strong style="color: #a8c3a4">Luna Health</strong>
        </a>

        <div class="d-flex align-items-center">
          <div class="dropdown me-3">
            <button
              class="btn btn-link text-muted position-relative"
              type="button"
              data-bs-toggle="dropdown"
            >
              <i class="fas fa-bell fa-lg"></i>
              <span
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
              >
                3
              </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">New client message</a></li>
              <li><a class="dropdown-item" href="#">Session reminder</a></li>
              <li><a class="dropdown-item" href="#">Schedule update</a></li>
            </ul>
          </div>

          <div class="dropdown">
            <a
              href="#"
              class="d-flex align-items-center text-decoration-none dropdown-toggle"
              data-bs-toggle="dropdown"
            >
              <div class="profile-img me-2">
                <img
                  src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=40&h=40&fit=crop&crop=face"
                  alt="Dr. Sarah Johnson"
                  class="rounded-circle"
                  width="40"
                  height="40"
                />
              </div>
              <div class="text-start">
                <div class="fw-semibold text-dark">Dr. Sarah Johnson</div>
                <small class="text-muted">Licensed Therapist</small>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="#"
                  ><i class="fas fa-user me-2"></i>Profile</a
                >
              </li>
              <li>
                <a class="dropdown-item" href="#"
                  ><i class="fas fa-cog me-2"></i>Settings</a
                >
              </li>
              <li><hr class="dropdown-divider" /></li>
              <li>
                <a class="dropdown-item" href="#"
                  ><i class="fas fa-sign-out-alt me-2"></i>Logout</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div class="container-fluid" style="margin-top: 76px">
      <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
          <div class="position-sticky pt-3">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <i class="fas fa-tachometer-alt me-2"></i>
                  Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-calendar-alt me-2"></i>
                  Schedule
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-users me-2"></i>
                  Clients
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-video me-2"></i>
                  Sessions
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-file-medical-alt me-2"></i>
                  Notes
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-chart-bar me-2"></i>
                  Analytics
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-envelope me-2"></i>
                  Messages
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h1 class="h2">Good morning, Dr. Johnson</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button type="button" class="btn btn-outline-secondary">
                  <i class="fas fa-calendar-plus me-1"></i>New Session
                </button>
                <button
                  type="button"
                  class="btn btn-primary"
                  style="background-color: #a8c3a4; border-color: #a8c3a4"
                >
                  <i class="fas fa-video me-1"></i>Join Session
                </button>
              </div>
            </div>
          </div>

          <!-- Stats Cards -->
          <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <div
                        class="text-xs font-weight-bold text-uppercase mb-1"
                        style="color: #a8c3a4"
                      >
                        Today's Sessions
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        8
                      </div>
                    </div>
                    <div class="col-auto">
                      <i
                        class="fas fa-calendar-day fa-2x"
                        style="color: #a8c3a4"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <div
                        class="text-xs font-weight-bold text-uppercase mb-1"
                        style="color: #a8c3a4"
                      >
                        Active Clients
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        34
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x" style="color: #a8c3a4"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <div
                        class="text-xs font-weight-bold text-uppercase mb-1"
                        style="color: #a8c3a4"
                      >
                        This Week
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        42 hours
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clock fa-2x" style="color: #a8c3a4"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <div
                        class="text-xs font-weight-bold text-uppercase mb-1"
                        style="color: #a8c3a4"
                      >
                        Revenue (MTD)
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        $4,280
                      </div>
                    </div>
                    <div class="col-auto">
                      <i
                        class="fas fa-dollar-sign fa-2x"
                        style="color: #a8c3a4"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Today's Schedule & Recent Activity -->
          <div class="row">
            <!-- Today's Schedule -->
            <div class="col-lg-8 mb-4">
              <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                  <h6 class="m-0 font-weight-bold" style="color: #a8c3a4">
                    Today's Schedule
                  </h6>
                </div>
                <div class="card-body">
                  <div class="timeline">
                    <div class="timeline-item">
                      <div class="timeline-time">9:00 AM</div>
                      <div class="timeline-content">
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div>
                            <h6 class="mb-1">Individual Session - Sarah M.</h6>
                            <small class="text-muted"
                              >Anxiety & Depression Support</small
                            >
                          </div>
                          <button class="btn btn-sm btn-outline-primary">
                            Join
                          </button>
                        </div>
                      </div>
                    </div>

                    <div class="timeline-item">
                      <div class="timeline-time">10:30 AM</div>
                      <div class="timeline-content">
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div>
                            <h6 class="mb-1">
                              Couples Session - John & Mary K.
                            </h6>
                            <small class="text-muted"
                              >Communication Issues</small
                            >
                          </div>
                          <button class="btn btn-sm btn-outline-primary">
                            Join
                          </button>
                        </div>
                      </div>
                    </div>

                    <div class="timeline-item">
                      <div class="timeline-time">2:00 PM</div>
                      <div class="timeline-content">
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div>
                            <h6 class="mb-1">Teen Session - Alex R.</h6>
                            <small class="text-muted">Academic Stress</small>
                          </div>
                          <button class="btn btn-sm btn-outline-primary">
                            Join
                          </button>
                        </div>
                      </div>
                    </div>

                    <div class="timeline-item">
                      <div class="timeline-time">3:30 PM</div>
                      <div class="timeline-content">
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div>
                            <h6 class="mb-1">Individual Session - Diana L.</h6>
                            <small class="text-muted">Postpartum Support</small>
                          </div>
                          <button class="btn btn-sm btn-outline-primary">
                            Join
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Recent Messages & Notifications -->
            <div class="col-lg-4 mb-4">
              <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                  <h6 class="m-0 font-weight-bold" style="color: #a8c3a4">
                    Recent Messages
                  </h6>
                </div>
                <div class="card-body">
                  <div class="message-item mb-3">
                    <div class="d-flex">
                      <img
                        src="https://images.unsplash.com/photo-1494790108755-2616b612b95d?w=40&h=40&fit=crop&crop=face"
                        class="rounded-circle me-3"
                        width="40"
                        height="40"
                        alt="Client"
                      />
                      <div class="flex-grow-1">
                        <h6 class="mb-1">Sarah M.</h6>
                        <p class="mb-1 text-muted small">
                          Thank you for yesterday's session. I'm feeling much
                          better...
                        </p>
                        <small class="text-muted">2 hours ago</small>
                      </div>
                    </div>
                  </div>

                  <div class="message-item mb-3">
                    <div class="d-flex">
                      <img
                        src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face"
                        class="rounded-circle me-3"
                        width="40"
                        height="40"
                        alt="Client"
                      />
                      <div class="flex-grow-1">
                        <h6 class="mb-1">John K.</h6>
                        <p class="mb-1 text-muted small">
                          Can we reschedule tomorrow's appointment?
                        </p>
                        <small class="text-muted">4 hours ago</small>
                      </div>
                    </div>
                  </div>

                  <div class="message-item">
                    <div class="d-flex">
                      <img
                        src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=40&h=40&fit=crop&crop=face"
                        class="rounded-circle me-3"
                        width="40"
                        height="40"
                        alt="Client"
                      />
                      <div class="flex-grow-1">
                        <h6 class="mb-1">Diana L.</h6>
                        <p class="mb-1 text-muted small">
                          I've been practicing the breathing exercises...
                        </p>
                        <small class="text-muted">6 hours ago</small>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer bg-white">
                  <a href="#" class="btn btn-sm btn-outline-primary w-100"
                    >View All Messages</a
                  >
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="row">
            <div class="col-12">
              <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                  <h6 class="m-0 font-weight-bold" style="color: #a8c3a4">
                    Quick Actions
                  </h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 mb-3">
                      <button class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-user-plus fa-2x mb-2"></i><br />
                        Add New Client
                      </button>
                    </div>
                    <div class="col-md-3 mb-3">
                      <button class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-calendar-plus fa-2x mb-2"></i><br />
                        Schedule Session
                      </button>
                    </div>
                    <div class="col-md-3 mb-3">
                      <button class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-file-medical-alt fa-2x mb-2"></i><br />
                        Write Notes
                      </button>
                    </div>
                    <div class="col-md-3 mb-3">
                      <button class="btn btn-outline-primary w-100 py-3">
                        <i class="fas fa-chart-line fa-2x mb-2"></i><br />
                        View Reports
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <style>
      body {
        font-family: "Inter", sans-serif;
        background-color: #f8f9fa;
      }

      .sidebar {
        min-height: calc(100vh - 76px);
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.1);
      }

      .sidebar .nav-link {
        color: #6c757d;
        padding: 12px 16px;
        margin-bottom: 4px;
        border-radius: 8px;
        transition: all 0.3s ease;
      }

      .sidebar .nav-link:hover {
        color: #a8c3a4;
        background-color: rgba(168, 195, 164, 0.1);
      }

      .sidebar .nav-link.active {
        color: #a8c3a4;
        background-color: rgba(168, 195, 164, 0.15);
        font-weight: 600;
      }

      .card {
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }

      .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
      }

      .timeline {
        position: relative;
      }

      .timeline-item {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
      }

      .timeline-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
      }

      .timeline-time {
        min-width: 80px;
        font-weight: 600;
        color: #a8c3a4;
        font-size: 14px;
      }

      .timeline-content {
        flex: 1;
        margin-left: 20px;
      }

      .message-item {
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f3f4;
      }

      .message-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
      }

      .btn-primary {
        background-color: #a8c3a4;
        border-color: #a8c3a4;
      }

      .btn-primary:hover {
        background-color: #96b391;
        border-color: #96b391;
      }

      .btn-outline-primary {
        color: #a8c3a4;
        border-color: #a8c3a4;
      }

      .btn-outline-primary:hover {
        background-color: #a8c3a4;
        border-color: #a8c3a4;
      }

      .text-xs {
        font-size: 0.75rem;
      }

      .font-weight-bold {
        font-weight: 700 !important;
      }

      @media (max-width: 768px) {
        .sidebar {
          display: none;
        }

        main {
          margin-left: 0 !important;
        }
      }
    </style>
  </body>
</html>
