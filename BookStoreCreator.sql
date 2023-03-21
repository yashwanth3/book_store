CREATE DATABASE books;

USE  books;


CREATE TABLE `bookinventory` (
  `bookID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` longblob NOT NULL,
  `author` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `bookinventoryorder` (
  `orderID` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `paymentmode` varchar(30) NOT NULL,
  `bookID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




ALTER TABLE `bookinventory`
  ADD PRIMARY KEY (`bookID`);


ALTER TABLE `bookinventory`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;



ALTER TABLE `bookinventoryorder`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `bio_fk_bi` (`bookID`);


ALTER TABLE `bookinventoryorder`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;


ALTER TABLE `bookinventoryorder`
  ADD CONSTRAINT `bio_fk_bi` FOREIGN KEY (`bookID`) REFERENCES `bookinventory` (`bookID`);
COMMIT;