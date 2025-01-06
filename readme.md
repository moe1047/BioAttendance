# BioAttendance System 👆

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

A comprehensive attendance management system integrated with ZK Biometric devices.

</div>

## 🌟 Features

- **Biometric Integration**

  - Seamless connection with ZK biometric devices
  - Real-time attendance data synchronization
  - Multi-device support

- **Attendance Management**

  - Daily attendance tracking
  - Automatic presence/absence marking
  - Leave management system
  - Holiday calendar management

- **Advanced Reporting**

  - Daily attendance reports
  - Monthly detailed reports
  - Summarized monthly statistics
  - Custom date range reports
  - Export capabilities (PDF, Excel)

- **Time Tracking**

  - Latency calculation
  - Overtime monitoring
  - Break time tracking
  - Schedule management

- **Financial Calculations**

  - Latency cost equivalence
  - Overtime payment calculation
  - Automated payslip generation
  - Salary deduction management

- **Dashboard & Analytics**
  - Real-time attendance overview
  - Employee presence statistics
  - Latency trends
  - Department-wise analytics

## 💻 System Requirements

- PHP >= 8.0
- Laravel >= 9.0
- MySQL >= 5.7
- Composer
- Node.js & NPM

## 🔧 Configuration

### Biometric Device Setup

1. Ensure your ZK device is connected to the network
2. Add device details in the admin panel:
   - IP Address
   - Port
   - Device ID
   - Connection type

### Environment Variables

env
DEVICE_TIMEOUT=30
ATTENDANCE_START_TIME=09:00
LATENCY_GRACE_PERIOD=15

## 📊 Reports

The system generates various reports including:

- Daily Attendance Status
- Monthly Attendance Summary
- Latency Reports
- Overtime Reports
- Payroll Statements
- Custom Period Reports

## 👥 User Roles

- **Admin**: Full system access
- **HR Manager**: Attendance and employee management
- **Department Head**: Department-specific reports
- **Employee**: Personal attendance view

## 🔐 Security

- Role-based access control
- Encrypted data transmission
- Audit logging
- Session management

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

<div align="center">
Made with ❤️ by Agent Mo
</div>
