
--
-- Database: `portfolio_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(255) NOT NULL,
  `catname` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='categories for articles (posts table)';

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `catname`, `description`) VALUES
(1, 'Photography', 'The photography category contains ... '),
(2, 'Film Studies', 'The film studies category shall encapsulate ...'),
(3, 'Film Production', 'The production category covers ... ');

-- --------------------------------------------------------

--
-- Table structure for table `category_photo`
--

CREATE TABLE `category_photo` (
  `id` int(255) NOT NULL,
  `catname` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_photo`
--

INSERT INTO `category_photo` (`id`, `catname`, `description`) VALUES
(1, 'Portrait', ''),
(2, 'Landscape', ''),
(3, 'Commercial', ''),
(4, 'Travel', ''),
(5, 'Weddings', ''),
(6, 'Editorial', '');

-- --------------------------------------------------------

--
-- Table structure for table `general_info`
--

CREATE TABLE `general_info` (
  `field_name` varchar(255) NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_info`
--

INSERT INTO `general_info` (`field_name`, `info`) VALUES
('biography', 'Greetings, I\'m !'),
('resume', 'resume_2019.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE `photo` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `filedate` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_hide` tinyint(1) NOT NULL,
  `photoset_ID` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photo_sets`
--

CREATE TABLE `photo_sets` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `cover_photo` varchar(255) NOT NULL,
  `display_hide` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `date_created` date NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `posted_by` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hits` int(11) NOT NULL,
  `post_cat` int(11) NOT NULL,
  `display_hide` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fileextension` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `index_vid` tinyint(1) NOT NULL,
  `submit_date` date NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_hide` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vid_details`
--

CREATE TABLE `vid_details` (
  `id` int(255) NOT NULL,
  `details` text NOT NULL,
  `video_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_photo`
--
ALTER TABLE `category_photo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_info`
--
ALTER TABLE `general_info`
  ADD PRIMARY KEY (`field_name`);

--
-- Indexes for table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photo_sets`
--
ALTER TABLE `photo_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vid_details`
--
ALTER TABLE `vid_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category_photo`
--
ALTER TABLE `category_photo`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `photo_sets`
--
ALTER TABLE `photo_sets`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vid_details`
--
ALTER TABLE `vid_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
