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
  `userID` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

### 🔹 `posts` Table
```sql
CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `petName` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ownerID` int(11) DEFAULT NULL,
  `isPublished` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

