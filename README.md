# 🐾 adopt-pet | Pet Selling Portal

## 🔧 Features

- User Registration and Login
- Create, Edit, and Delete Pet Posts
- Upload pet images
- Mark posts as **Public** (visible to all) or **Private** (visible only to the user)
- View posts (public feed and personal dashboard)
- contact owner through the email



## 🗃️ Database Schema

### 🔹 `users` Table
```sql
CREATE TABLE `users` (
  `userID` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `contact` VARCHAR(20) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

```

### 🔹 `posts` Table
```sql
CREATE TABLE `posts` (
  `postID` INT(11) NOT NULL AUTO_INCREMENT,
  `petName` VARCHAR(100) DEFAULT NULL,
  `type` VARCHAR(50) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `ownerID` INT(11) DEFAULT NULL,
  `isPublished` TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (`postID`),
  FOREIGN KEY (`ownerID`) REFERENCES `users`(`userID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

