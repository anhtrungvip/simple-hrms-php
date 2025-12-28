<?php
// =====================================================
// FILE: index.php
// CHỨC NĂNG: CRUD - Quản lý nhân viên
// VỊ TRÍ LƯU: C:\xampp\htdocs\qlns\index.php
// =====================================================

// Kết nối MySQL Server từ file config.php
require 'config.php';

$message = '';

// =====================================================
// 1. CREATE - THÊM NHÂN VIÊN MỚI VÀO SERVER
// =====================================================
if(isset($_POST['them'])) {
    $ho_ten = $_POST['ho_ten'];
    $chuc_vu = $_POST['chuc_vu'];
    $luong = $_POST['luong'];
    
    // Câu lệnh SQL INSERT - Thêm vào MySQL Server
    $sql = "INSERT INTO employees (ho_ten, chuc_vu, luong) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$ho_ten, $chuc_vu, $luong]);
    
    $message = "Đã thêm nhân viên vào MySQL Server!";
}

// =====================================================
// 2. DELETE - XÓA NHÂN VIÊN KHỎI SERVER
// =====================================================
if(isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    
    // Câu lệnh SQL DELETE - Xóa khỏi MySQL Server
    $sql = "DELETE FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    
    $message = "Đã xóa nhân viên khỏi MySQL Server!";
}

// =====================================================
// 3. UPDATE - CẬP NHẬT THÔNG TIN TRÊN SERVER
// =====================================================
if(isset($_POST['capnhat'])) {
    $id = $_POST['id'];
    $ho_ten = $_POST['ho_ten'];
    $chuc_vu = $_POST['chuc_vu'];
    $luong = $_POST['luong'];
    
    // Câu lệnh SQL UPDATE - Sửa trên MySQL Server
    $sql = "UPDATE employees SET ho_ten=?, chuc_vu=?, luong=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$ho_ten, $chuc_vu, $luong, $id]);
    
    $message = "Đã cập nhật thông tin trên MySQL Server!";
}

// Lấy dữ liệu để sửa (nếu click nút Sửa)
$edit = null;
if(isset($_GET['sua'])) {
    $id = $_GET['sua'];
    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $edit = $stmt->fetch();
}

// =====================================================
// 4. READ - ĐỌC DỮ LIỆU TỪ SERVER VÀ HIỂN THỊ
// =====================================================
$sql = "SELECT * FROM employees";
$stmt = $conn->query($sql);
$employees = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
 <input type="text" id="txt1" onkeyup = "showHint(this.value);">
    <meta charset="UTF-8">
    <title>Quản Lý Nhân Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f5f5f5;
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
        }
        .message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin: 15px 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            margin: 15px 0;
        }
        th {
            background: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        input[type="text"], input[type="number"] {
            padding: 8px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 8px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }
        button:hover {
            background: #0056b3;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .form-box {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <h1>QUẢN LÝ NHÂN VIÊN</h1>
    
    <!-- Hiển thị thông báo -->
    <?php if($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <!-- ============================================ -->
    <!-- FORM THÊM / SỬA NHÂN VIÊN -->
    <!-- ============================================ -->
    <div class="form-box">
        <h2><?php echo $edit ? 'SỬA NHÂN VIÊN' : 'THÊM NHÂN VIÊN MỚI'; ?></h2>
        
        <form method="POST">
            <?php if($edit): ?>
                <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">
            <?php endif; ?>
            
            <table border="0" cellpadding="5">
                <tr>
                    <td><strong>Họ tên:</strong></td>
                    <td>
                        <input type="text" name="ho_ten" 
                               value="<?php echo $edit ? $edit['ho_ten'] : ''; ?>" 
                               placeholder="Nhập họ tên" required>
                    </td>
                </tr>
                <tr>
                    <td><strong>Chức vụ:</strong></td>
                    <td>
                        <input type="text" name="chuc_vu" 
                               value="<?php echo $edit ? $edit['chuc_vu'] : ''; ?>" 
                               placeholder="Nhập chức vụ" required>
                    </td>
                </tr>
                <tr>
                    <td><strong>Lương:</strong></td>
                    <td>
                        <input type="number" name="luong" 
                               value="<?php echo $edit ? $edit['luong'] : ''; ?>" 
                               placeholder="Nhập lương" required>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php if($edit): ?>
                            <button type="submit" name="capnhat">CẬP NHẬT</button>
                            <a href="index.php"><button type="button">HỦY</button></a>
                        <?php else: ?>
                            <button type="submit" name="them">THÊM MỚI</button>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    
    <!-- ============================================ -->
    <!-- BẢNG DANH SÁCH NHÂN VIÊN TỪ SERVER -->
    <!-- ============================================ -->
    <h2>DANH SÁCH NHÂN VIÊN</h2>
    
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ Tên</th>
                <th>Chức Vụ</th>
                <th>Lương</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($employees) > 0): ?>
                <?php foreach($employees as $emp): ?>
                <tr>
                    <td><?php echo $emp['id']; ?></td>
                    <td><?php echo $emp['ho_ten']; ?></td>
                    <td><?php echo $emp['chuc_vu']; ?></td>
                    <td><?php echo number_format($emp['luong'], 0, ',', '.'); ?> đ</td>
                    <td>
                        <a href="?sua=<?php echo $emp['id']; ?>">Sửa</a> | 
                        <a href="?xoa=<?php echo $emp['id']; ?>" 
                           onclick="return confirm('Xác nhận xóa nhân viên này khỏi MySQL Server?')">
                           Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">
                        Chưa có dữ liệu trên MySQL Server
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>   
</body>
</html>