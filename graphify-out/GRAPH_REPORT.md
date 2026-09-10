# Graph Report - .  (2026-09-09)

## Corpus Check
- Large corpus: 327 files · ~1,152,686 words. Semantic extraction will be expensive (many Claude tokens). Consider running on a subfolder.

## Summary
- 1198 nodes · 1683 edges · 250 communities (165 shown, 85 thin omitted)
- Extraction: 96% EXTRACTED · 4% INFERRED · 0% AMBIGUOUS · INFERRED: 62 edges (avg confidence: 0.78)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- DB Seeders
- Giao An Menu Controller
- Chu De Enums
- Hoc Vien Request
- Admin Controllers
- Admin Controllers
- Admin Diem Danh Form Requests
- Project Root Files
- Bieu Mau Models
- Admin Controllers
- Cai Dat Controllers
- Cham Cong Controllers
- Co So Controllers
- Giao An Controllers
- Project Root Files
- Project Root Files
- Models
- Hoc Phi Controllers
- Hoc Vien Controllers
- Phieu Luong Controllers
- Project Root Files
- Profile Controllers
- Tien San Controllers
- Project Root Files
- Project Root Files
- Bieu Mau Mau Trong Request
- Bieu Mau Request
- Cai Dat Form Requests
- Project Root Files
- Phieu Luong Ctv Request
- Phieu Luong Nhan Vien Request
- Login Request
- Project Root Files
- Project Root Files
- Project Root Files
- Repositories
- So Do Renderer
- Composer
- Composer
- Package
- Common
- Datepicker
- Daterangepicker
- Fake Data
- Branches Modal
- Attendance
- Branches
- Chamcong
- Phieuluongctv
- Phieuluongnhanvien
- Sodo Designer
- Students
- Tuition
- Index
- Index
- Login
- Index
- Menu
- Index
- Index
- Index
- Index
- Form
- Index
- Create
- Edit
- Index
- Menu
- Index
- Index
- Menu
- Admin
- Create
- Edit
- Index
- Create
- Edit
- Index
- Index
- Index
- Detail
- Index
- Index
- Index
- Index
- Index
- Index
- Index
- Example Test Tests
- Example Test Tests
- Readme
- Robots
- Human Authenticate Image
- Shape1 Image
- Shape1
- Shape1
- Bhxh Image
- Bhxh
- Bhxh
- Bhxh
- Bhxh
- Bhxh
- Bhxh
- Bieu Mau Cong Tac Phi
- Bieu Mau Hoan Dan 9
- Bieu Mau Hoan Tien Tam
- Bieu Mau Khac Image
- Cap 2 Image
- Chuyen Bong Kiem Soat Bong
- Dan Bong Qua Nguoi Image
- Di Chuyen Khong Bong To
- Game 1 Image
- Game 2 Image
- Game 3 Image
- Khoi Dong Image
- Mam Non Image
- Phong Ngu Image
- Sut Bong Tan Cong Image
- Tieu Hoc Image
- Tong Hop Image
- Hoa Don An Uong Image
- Hoa Don Dong Phuc Image
- Hoa Don Dung Cu Image
- Hoa Don Khac Image
- Hoa Don To Roi Image
- Logo Image

## God Nodes (most connected - your core abstractions)
1. `Controller` - 43 edges
2. `CoSo` - 33 edges
3. `HocVien` - 31 edges
4. `GiaoVien` - 29 edges
5. `HocVienTraiNghiem` - 17 edges
6. `DashboardService` - 17 edges
7. `HocPhi` - 16 edges
8. `Laravel Framework` - 16 edges
9. `ChamCongGiaoVien` - 15 edges
10. `BaseRepository` - 15 edges

## Surprising Connections (you probably didn't know these)
- `remove_vietnamese_accents()` --calls--> `scopeOrWhereUnaccentedLike()`  [INFERRED]
  app/Helpers/helpers.php → app/Traits/SearchableUnaccented.php
- `remove_vietnamese_accents()` --calls--> `scopeWhereUnaccentedLike()`  [INFERRED]
  app/Helpers/helpers.php → app/Traits/SearchableUnaccented.php
- `BieuMauController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/BieuMauController.php → app/Http/Controllers/Controller.php
- `CaiDatHocPhiController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/CaiDatHocPhiController.php → app/Http/Controllers/Controller.php
- `CaiDatTienLuongController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/CaiDatTienLuongController.php → app/Http/Controllers/Controller.php

## Import Cycles
- None detected.

## Communities (250 total, 85 thin omitted)

### Community 2 - "DB Seeders"
Cohesion: 0.07
Nodes (16): FixVietnameseUsernames, remove_vietnamese_accents(), generate_username_from_name(), User, scopeWhereUnaccentedLike(), scopeOrWhereUnaccentedLike(), ChucNangSeeder, CoSoSeeder (+8 more)

### Community 24 - "Chu De Enums"
Cohesion: 0.24
Nodes (5): getLabel(), getLabelCoSo(), getLabel(), getLabelCoSo(), GiaoAnDemoSeeder

### Community 0 - "Admin Controllers"
Cohesion: 0.05
Nodes (4): HoaDonController, HoaDonRequest, HoaDon, options()

### Community 6 - "Admin Controllers"
Cohesion: 0.09
Nodes (5): HocVienTraiNghiemController, HocVienTraiNghiemRequest, HocVienTraiNghiem, AppServiceProvider, Illuminate\Support\ServiceProvider

### Community 7 - "Admin Diem Danh Form Requests"
Cohesion: 0.10
Nodes (4): DiemDanhController, DiemDanhBuRequest, DiemDanhRequest, DiemDanh

### Community 3 - "Project Root Files"
Cohesion: 0.10
Nodes (10): HocVienExport, DashboardController, DashboardService, XuatPhieuLuongCtv, XuatPhieuLuongNhanVien, Illuminate\Support\Collection, Maatwebsite\Excel\Concerns\FromCollection, Maatwebsite\Excel\Concerns\WithHeadings (+2 more)

### Community 25 - "Bieu Mau Models"
Cohesion: 0.26
Nodes (3): BieuMauController, BieuMau, BieuMauMauTrong

### Community 16 - "Admin Controllers"
Cohesion: 0.16
Nodes (4): CaiDatHocPhiController, CaiDatHocPhiRequest, CaiDatHocPhi, self

### Community 19 - "Co So Controllers"
Cohesion: 0.20
Nodes (3): CoSoController, CoSoRequest, CoSo

### Community 20 - "Giao An Controllers"
Cohesion: 0.20
Nodes (3): GiaoAnController, GiaoAnRequest, GiaoAn

### Community 17 - "Project Root Files"
Cohesion: 0.15
Nodes (5): self, SodoMauSac, UserFactory, static, Illuminate\Database\Eloquent\Factories\Factory

### Community 42 - "Project Root Files"
Cohesion: 0.38
Nodes (3): CapHocGiaoAn, ChuDeGiaoAn, Illuminate\Validation\Validator

### Community 11 - "Models"
Cohesion: 0.13
Nodes (4): GiaoVienController, GiaoVienRequest, ChucNang, GiaoVien

### Community 18 - "Hoc Phi Controllers"
Cohesion: 0.18
Nodes (3): HocPhiController, HocPhiRequest, HocPhi

### Community 29 - "Phieu Luong Controllers"
Cohesion: 0.35
Nodes (3): PhieuLuongCtvController, Carbon, PhieuLuongCtv

### Community 21 - "Project Root Files"
Cohesion: 0.30
Nodes (4): PhieuLuongNhanVienController, Carbon, PhieuLuongNhanVien, Illuminate\Http\Request

### Community 22 - "Tien San Controllers"
Cohesion: 0.20
Nodes (3): TienSanController, TienSanRequest, TienSan

### Community 30 - "Project Root Files"
Cohesion: 0.23
Nodes (6): AuthController, Controller, Illuminate\Foundation\Auth\Access\AuthorizesRequests, Illuminate\Foundation\Bus\DispatchesJobs, Illuminate\Foundation\Validation\ValidatesRequests, Illuminate\Routing\Controller

### Community 49 - "Project Root Files"
Cohesion: 0.60
Nodes (3): CheckQuyen, Closure, Symfony\Component\HttpFoundation\Response

### Community 33 - "Cai Dat Form Requests"
Cohesion: 0.22
Nodes (3): CaiDatLuongThayRequest, CaiDatTienLuongRequest, Illuminate\Foundation\Http\FormRequest

### Community 39 - "Project Root Files"
Cohesion: 0.25
Nodes (3): ChamCongHangLoatRequest, Validator, Illuminate\Contracts\Validation\Validator

### Community 10 - "Project Root Files"
Cohesion: 0.16
Nodes (4): UserPermission, Illuminate\Database\Eloquent\Factories\HasFactory, Illuminate\Database\Eloquent\Model, Illuminate\Database\Eloquent\Relations\BelongsTo

### Community 40 - "Project Root Files"
Cohesion: 0.32
Nodes (3): DiaDiem, Illuminate\Database\Eloquent\Relations\HasMany, Illuminate\Database\Eloquent\Relations\HasManyThrough

### Community 5 - "Repositories"
Cohesion: 0.09
Nodes (8): BaseRepository, RepositoryInterface, advancedGet(), advancedGetFirst(), queryByConditions(), Illuminate\Contracts\Pagination\LengthAwarePaginator, Illuminate\Database\Eloquent\Builder, Illuminate\Database\Eloquent\Collection

### Community 1 - "Composer"
Cohesion: 0.05
Nodes (43): $schema, name, type, description, keywords, laravel, framework, license (+35 more)

### Community 8 - "Composer"
Cohesion: 0.08
Nodes (26): scripts, setup, composer install, @php -r \"file_exists('.env') || copy('.env.example', '.env');\, @php artisan key:generate, @php artisan migrate --force, npm install, npm run build (+18 more)

### Community 12 - "Package"
Cohesion: 0.10
Nodes (19): $schema, private, type, scripts, build, dev, devDependencies, @tailwindcss/vite (+11 more)

### Community 23 - "Common"
Cohesion: 0.17
Nodes (6): openModal(), closeModal(), confirmAction(), formatMoney(), unformatMoney(), attachMoneyFormatter()

### Community 43 - "Datepicker"
Cohesion: 0.57
Nodes (6): pad2(), parseISO(), toISO(), toDisplay(), enhance(), scan()

### Community 41 - "Daterangepicker"
Cohesion: 0.50
Nodes (7): pad2(), toISO(), toDisplay(), parseISO(), sameDay(), init(), scan()

### Community 13 - "Fake Data"
Cohesion: 0.11
Nodes (16): fakeTeacherNames, fakeTeachers, tenCoSo, branches, branchLabel(), branchNameById(), hoTenHV, nickHV (+8 more)

### Community 34 - "Attendance"
Cohesion: 0.27
Nodes (6): attendanceForm, escapeHtml(), themHocVienHocBuPending(), appendPendingHocBuRow(), xoaHocVienHocBuPending(), capNhatHbEmptyMsg()

### Community 15 - "Chamcong"
Cohesion: 0.24
Nodes (16): ccDanhSachCho, formatTien(), openChamCongThemModal(), ccChonTab(), ccChonTrangThai(), ccCapNhatDonGia(), ccTinhThanhTien(), ccResetFormThay() (+8 more)

### Community 46 - "Phieuluongnhanvien"
Cohesion: 0.60
Nodes (5): layGiaTri(), layTrangThaiTick(), ganText(), chonGiaoVien(), tinhLai()

### Community 4 - "Sodo Designer"
Cohesion: 0.12
Nodes (27): taoId(), dongBoHiddenInput(), tySoKichThuoc(), noiDungHinh(), mauSac(), renderObject(), themVatDung(), xoaVatDung() (+19 more)

### Community 47 - "Students"
Cohesion: 0.53
Nodes (4): locCoSoHocVien(), chonTatCaCoSoHocVien(), capNhatSoLuongCoSoHocVien(), openStudentModal()

### Community 38 - "Tuition"
Cohesion: 0.42
Nodes (7): capNhatTrangThaiHocPhi(), clearReferrerSelection(), setReferrer(), escapeHtmlTu(), taoDotBoxElement(), themDotThanhToan(), openTuitionModal()

### Community 14 - "Admin"
Cohesion: 0.11
Nodes (17): partials._sidebar, partials._topbar, partials.modals._student, partials.modals._tuition, partials.modals._trial, partials.modals._branch, partials.modals._teacher, partials.modals._quyengiaovien (+9 more)

### Community 45 - "Example Test Tests"
Cohesion: 0.40
Nodes (3): ExampleTest, TestCase, Illuminate\Foundation\Testing\TestCase

### Community 9 - "Readme"
Cohesion: 0.08
Nodes (25): Laravel Framework, Simple, Fast Routing Engine, Dependency Injection Container, Session Storage Backends, Cache Storage Backends, Eloquent Database ORM, Database Agnostic Schema Migrations, Background Job Processing (Queues) (+17 more)

### Community 99 - "Human Authenticate Image"
Cohesion: 0.67
Nodes (3): Human Authenticate Illustration, Soccer Player Kicking Ball (3D Illustration), Human Verification UI Asset

## Knowledge Gaps
- **185 isolated node(s):** `$schema`, `name`, `type`, `description`, `laravel` (+180 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **85 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Controller` connect `Project Root Files` to `Admin Controllers`, `Profile Controllers`, `Project Root Files`, `Cai Dat Controllers`, `Cham Cong Controllers`, `Admin Controllers`, `Admin Diem Danh Form Requests`, `Models`, `Admin Controllers`, `Hoc Phi Controllers`, `Co So Controllers`, `Giao An Controllers`, `Project Root Files`, `Tien San Controllers`, `Bieu Mau Models`, `Hoc Vien Controllers`, `Giao An Menu Controller`, `Phieu Luong Controllers`?**
  _High betweenness centrality (0.037) - this node is a cross-community bridge._
- **Why does `CoSo` connect `Co So Controllers` to `DB Seeders`, `Project Root Files`, `Admin Controllers`, `Admin Diem Danh Form Requests`, `Project Root Files`, `Project Root Files`, `Hoc Phi Controllers`, `Tien San Controllers`, `Project Root Files`, `Hoc Vien Controllers`, `Hoc Vien Request`?**
  _High betweenness centrality (0.021) - this node is a cross-community bridge._
- **Why does `HocVien` connect `Hoc Vien Controllers` to `DB Seeders`, `Project Root Files`, `Admin Controllers`, `Admin Diem Danh Form Requests`, `Project Root Files`, `Project Root Files`, `Models`, `Admin Controllers`, `Hoc Phi Controllers`, `Project Root Files`, `Hoc Vien Request`?**
  _High betweenness centrality (0.020) - this node is a cross-community bridge._
- **What connects `$schema`, `name`, `type` to the rest of the system?**
  _185 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `DB Seeders` be split into smaller, more focused modules?**
  _Cohesion score 0.06829268292682927 - nodes in this community are weakly interconnected._
- **Should `Admin Controllers` be split into smaller, more focused modules?**
  _Cohesion score 0.05272108843537415 - nodes in this community are weakly interconnected._
- **Should `Admin Controllers` be split into smaller, more focused modules?**
  _Cohesion score 0.09359605911330049 - nodes in this community are weakly interconnected._