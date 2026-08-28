@extends('layouts.app')


@section('content')

      <section class="section">
        <div class="card">
          <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
              <h5 class="card-title mb-0">All Users</h5>
              <span class="badge bg-primary-light text-primary">248 users</span>
            </div>
            <div class="d-flex flex-wrap gap-2">
              <div class="input-group" style="width: 250px;">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Search users...">
              </div>
              <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                  <i class="bi bi-funnel"></i> Filter
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="users.html#">All Users</a></li>
                  <li><a class="dropdown-item" href="users.html#">Active</a></li>
                  <li><a class="dropdown-item" href="users.html#">Inactive</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="users.html#">Admins</a></li>
                  <li><a class="dropdown-item" href="users.html#">Managers</a></li>
                  <li><a class="dropdown-item" href="users.html#">Users</a></li>
                </ul>
              </div>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-plus-lg me-1"></i> Add User
              </button>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead>
                  <tr>
                    <th style="width: 40px;">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                      </div>
                    </th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Active</th>
                    <th>Joined</th>
                    <th style="width: 100px;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <img src="assets/img/avatars/avatar-1.webp" alt="User" class="rounded-circle" width="40" height="40">
                        <div>
                          <div class="fw-semibold">Sarah Johnson</div>
                          <div class="text-muted small"><a href="https://bootstrapmade.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="3c4f5d4e5d5412565354524f53527c59445d514c5059125f5351">[email&#160;protected]</a></div>
                        </div>
                      </div>
                    </td>
                    <td><span class="badge bg-danger-light text-danger">Admin</span></td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>Just now</td>
                    <td>Jan 15, 2024</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="users-view.html"><i class="bi bi-eye me-2"></i> View</a></li>
                          <li><a class="dropdown-item" href="users-edit.html"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item text-danger" href="users.html#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <img src="assets/img/avatars/avatar-2.webp" alt="User" class="rounded-circle" width="40" height="40">
                        <div>
                          <div class="fw-semibold">Michael Chen</div>
                          <div class="text-muted small"><a href="https://bootstrapmade.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="3c51125f5459527c59445d514c5059125f5351">[email&#160;protected]</a></div>
                        </div>
                      </div>
                    </td>
                    <td><span class="badge bg-warning-light text-warning">Manager</span></td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>5 min ago</td>
                    <td>Feb 3, 2024</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="users-view.html"><i class="bi bi-eye me-2"></i> View</a></li>
                          <li><a class="dropdown-item" href="users-edit.html"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item text-danger" href="users.html#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <img src="assets/img/avatars/avatar-3.webp" alt="User" class="rounded-circle" width="40" height="40">
                        <div>
                          <div class="fw-semibold">Emily Rodriguez</div>
                          <div class="text-muted small"><a href="https://bootstrapmade.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d3b6bebabfaafda193b6abb2bea3bfb6fdb0bcbe">[email&#160;protected]</a></div>
                        </div>
                      </div>
                    </td>
                    <td><span class="badge bg-info-light text-info">User</span></td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>2 hours ago</td>
                    <td>Mar 12, 2024</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="users-view.html"><i class="bi bi-eye me-2"></i> View</a></li>
                          <li><a class="dropdown-item" href="users-edit.html"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item text-danger" href="users.html#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <img src="assets/img/avatars/avatar-4.webp" alt="User" class="rounded-circle" width="40" height="40">
                        <div>
                          <div class="fw-semibold">David Kim</div>
                          <div class="text-muted small"><a href="https://bootstrapmade.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="385c16535155785d40595548545d165b5755">[email&#160;protected]</a></div>
                        </div>
                      </div>
                    </td>
                    <td><span class="badge bg-info-light text-info">User</span></td>
                    <td><span class="badge bg-secondary">Inactive</span></td>
                    <td>3 days ago</td>
                    <td>Jan 28, 2024</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="users-view.html"><i class="bi bi-eye me-2"></i> View</a></li>
                          <li><a class="dropdown-item" href="users-edit.html"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item text-danger" href="users.html#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <img src="assets/img/avatars/avatar-5.webp" alt="User" class="rounded-circle" width="40" height="40">
                        <div>
                          <div class="fw-semibold">Jessica Taylor</div>
                          <div class="text-muted small"><a href="https://bootstrapmade.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="fd97d3899c8491928fbd98859c908d9198d39e9290">[email&#160;protected]</a></div>
                        </div>
                      </div>
                    </td>
                    <td><span class="badge bg-warning-light text-warning">Manager</span></td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>1 hour ago</td>
                    <td>Dec 5, 2023</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="users-view.html"><i class="bi bi-eye me-2"></i> View</a></li>
                          <li><a class="dropdown-item" href="users-edit.html"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item text-danger" href="users.html#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <img src="assets/img/avatars/avatar-6.webp" alt="User" class="rounded-circle" width="40" height="40">
                        <div>
                          <div class="fw-semibold">Robert Martinez</div>
                          <div class="text-muted small"><a href="https://bootstrapmade.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="40326e2d213234292e253a002538212d302c256e232f2d">[email&#160;protected]</a></div>
                        </div>
                      </div>
                    </td>
                    <td><span class="badge bg-info-light text-info">User</span></td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>30 min ago</td>
                    <td>Apr 18, 2024</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="users-view.html"><i class="bi bi-eye me-2"></i> View</a></li>
                          <li><a class="dropdown-item" href="users-edit.html"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item text-danger" href="users.html#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <img src="assets/img/avatars/avatar-7.webp" alt="User" class="rounded-circle" width="40" height="40">
                        <div>
                          <div class="fw-semibold">Amanda Wilson</div>
                          <div class="text-muted small"><a href="https://bootstrapmade.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="ec8dc29b85809f8382ac89948d819c8089c28f8381">[email&#160;protected]</a></div>
                        </div>
                      </div>
                    </td>
                    <td><span class="badge bg-info-light text-info">User</span></td>
                    <td><span class="badge bg-warning">Pending</span></td>
                    <td>Never</td>
                    <td>May 2, 2024</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="users-view.html"><i class="bi bi-eye me-2"></i> View</a></li>
                          <li><a class="dropdown-item" href="users-edit.html"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                          <li><a class="dropdown-item" href="users.html#"><i class="bi bi-envelope me-2"></i> Resend Invite</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item text-danger" href="users.html#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <img src="assets/img/avatars/avatar-8.webp" alt="User" class="rounded-circle" width="40" height="40">
                        <div>
                          <div class="fw-semibold">Chris Thompson</div>
                          <div class="text-muted small"><a href="https://bootstrapmade.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="c0a3eeb4a8afadb0b3afae80a5b8a1adb0aca5eea3afad">[email&#160;protected]</a></div>
                        </div>
                      </div>
                    </td>
                    <td><span class="badge bg-danger-light text-danger">Admin</span></td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>15 min ago</td>
                    <td>Nov 20, 2023</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="users-view.html"><i class="bi bi-eye me-2"></i> View</a></li>
                          <li><a class="dropdown-item" href="users-edit.html"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item text-danger" href="users.html#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 p-3 border-top">
              <div class="text-muted small">
                Showing 1 to 8 of 248 users
              </div>
              <nav>
                <ul class="pagination pagination-sm mb-0">
                  <li class="page-item disabled">
                    <a class="page-link" href="users.html#"><i class="bi bi-chevron-left"></i></a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="users.html#">1</a></li>
                  <li class="page-item"><a class="page-link" href="users.html#">2</a></li>
                  <li class="page-item"><a class="page-link" href="users.html#">3</a></li>
                  <li class="page-item"><a class="page-link" href="users.html#">...</a></li>
                  <li class="page-item"><a class="page-link" href="users.html#">31</a></li>
                  <li class="page-item">
                    <a class="page-link" href="users.html#"><i class="bi bi-chevron-right"></i></a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </section>

      <!-- Add User Modal -->
      <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add New User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" class="form-control" placeholder="Enter full name">
                </div>
                <div class="mb-3">
                  <label class="form-label">Email Address</label>
                  <input type="email" class="form-control" placeholder="Enter email address">
                </div>
                <div class="mb-3">
                  <label class="form-label">Role</label>
                  <select class="form-select">
                    <option value="">Select role...</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="user">User</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control" placeholder="Enter password">
                </div>
                <div class="mb-3">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" placeholder="Confirm password">
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="sendInvite" checked>
                  <label class="form-check-label" for="sendInvite">
                    Send welcome email with login details
                  </label>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary">Add User</button>
            </div>
          </div>
        </div>
      </div>
@endsection