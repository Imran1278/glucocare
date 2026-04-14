-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 10:51 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `glucocare_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `email`, `password`, `created_at`) VALUES
(1, 'Imran Ali', 'imranalichohan5@gmail.com', '$2y$10$BPSf6Mhy.0dspxO5dWVeM.a7GTIWAGZiJHGqzp518vDikpinj3Lp6', '2026-03-25 06:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `appliance_settings`
--

CREATE TABLE `appliance_settings` (
  `id` int(11) NOT NULL,
  `blue_tag` varchar(255) DEFAULT NULL,
  `main_title` varchar(255) DEFAULT NULL,
  `r1_t` varchar(255) DEFAULT NULL,
  `r1_d` text DEFAULT NULL,
  `r2_t` varchar(255) DEFAULT NULL,
  `r2_d` text DEFAULT NULL,
  `r3_t` varchar(255) DEFAULT NULL,
  `r3_d` text DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `why_tag` varchar(255) DEFAULT NULL,
  `why_title` text DEFAULT NULL,
  `why_desc` text DEFAULT NULL,
  `vision_t` varchar(255) DEFAULT NULL,
  `vision_d` text DEFAULT NULL,
  `mission_t` varchar(255) DEFAULT NULL,
  `mission_d` text DEFAULT NULL,
  `buttons_json` text DEFAULT NULL,
  `card_data_json` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appliance_settings`
--

INSERT INTO `appliance_settings` (`id`, `blue_tag`, `main_title`, `r1_t`, `r1_d`, `r2_t`, `r2_d`, `r3_t`, `r3_d`, `img1`, `img2`, `why_tag`, `why_title`, `why_desc`, `vision_t`, `vision_d`, `mission_t`, `mission_d`, `buttons_json`, `card_data_json`) VALUES
(1, 'Compelling Reasons To Choose', 'Appliance', 'Follow-Up Care', 'We ensure contiunity of care through regular follow-ups and communication, helping you stay on track with health goals', 'Patient Centered Approach', 'We prioritize your comfort and preferences, tailoring our services to meet you individuals needs', 'Convenient Access', 'Easily book appointments online with flexible hours that fit your schedule ', '1773654146_img1.jpg', '1773654146_img2.jpg', 'Why Book You Us?', 'We are committed to understanding your unique needs and delivering care', 'As a trusted healthcare provider in our community, we are passionate about promoting health and wellness beyond the clinic.', 'Our Vision', 'We envision a community where everyone has access to high-quality healthcare and resources they need.', 'Our Mission', 'Our mission is to deliver compassionate and innovative healthcare solutions.', '[{\"txt\":\"Search For Doctors\",\"url\":\"includes\\\\search-doctors.php\"},{\"txt\":\"Check Doctor Profile\",\"url\":\"includes\\\\all-doctors.php\"},{\"txt\":\"Schedule Appointment\",\"url\":\"includes\\\\schedule.php\"},{\"txt\":\"Get Your Solution\",\"url\":\"includes\\\\solutions.php\"}]', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `patient_phone` varchar(20) NOT NULL,
  `app_date` date NOT NULL,
  `app_time` varchar(20) NOT NULL,
  `app_type` varchar(50) NOT NULL,
  `app_notes` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `app_location` text DEFAULT NULL,
  `fee` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT 'default.jpg',
  `tags` varchar(100) DEFAULT 'General',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `exp` varchar(10) DEFAULT NULL,
  `patients` varchar(20) DEFAULT NULL,
  `awards` varchar(10) DEFAULT NULL,
  `university` varchar(255) DEFAULT NULL,
  `languages` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `availability` varchar(50) DEFAULT 'Available Now',
  `rating` decimal(2,1) DEFAULT 4.5,
  `schedule` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialty`, `bio`, `image`, `phone`, `email`, `address`, `exp`, `patients`, `awards`, `university`, `languages`, `price`, `availability`, `rating`, `schedule`) VALUES
(1, 'Prof. Dr. M. Akbar   Chaudhry', 'Cardiology', 'Prof. Dr. M. Akbar Chaudhry is a highly experienced cardiologist and medical educator in Lahore, Pakistan, with over 45 years in medicine, specializing in complex heart conditions like angiography, angioplasty, and cardiovascular surgery, holding fellowships from prestigious UK colleges, and serving as Principal for Fatima Jinnah Medical College and a key figure in establishing Azra Naheed Medical College.', '1770197333_doc1.jpg', '+92 300 4200330', 'dean.anmc@superior.edu.pk', '16, College Block, Allama Iqbal Town, Lahore, Pakistan', '47', '1k+', '5', 'College of Physicians of London', 'English, Urdu', '9.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"06:00 - 09:30\",\"location\":\"Cardiomed Clinic, Allama Iqbal Town, Lahore\"},\"Tuesday\":{\"time\":\"06:00 - 09:30\",\"location\":\"Cardiomed Clinic, Allama Iqbal Town, Lahore\"},\"Wednesday\":{\"time\":\"06:00 - 09:30\",\"location\":\"Cardiomed Clinic, Allama Iqbal Town, Lahore\"},\"Thursday\":{\"time\":\"06:00 - 09:30\",\"location\":\"Cardiomed Clinic, Allama Iqbal Town, Lahore\"},\"Friday\":{\"time\":\"06:00 - 09:30\",\"location\":\"Cardiomed Clinic, Allama Iqbal Town, Lahore\"},\"Saturday\":{\"time\":\"06:00 - 09:30\",\"location\":\"Cardiomed Clinic, Allama Iqbal Town, Lahore\"},\"Sunday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"}}'),
(2, 'Dr. Ahmad Usman', 'Cardiology', 'Dr. Ahmad Usman is a Consultant Cardiologist with over 20 years of experience. He is a graduate of Army Medical College Rawalpindi. He did his Fellowship in Internal Medicine (FCPS Medicine) and then did his second fellowship in Cardiology (FCPS Cardiology). He did his training in Cardiac CT from Johns Hopkins University USA and is a Diplomate American Board of Cardiac CT and holds the Fellowship of Society of Cardiovascular CT from USA. He has worked at Chelmsford Hospital UK and is a Fellow of the Royal College of Physicians (FRCP) Glasgow UK. He has written numerous research articles in not only local but also international medical journals. He is actively involved in the undergraduate as well as post graduate training of medical students and is currently an Associate Professor of Cardiology at CMH Lahore Medical College. He is a Supervisor in Cardiology with CPSP as well as an Examiner of FCPS Cardiology at CPSP. He has a special interest in complex coronary interventions and is skilled in both non-interventional and interventional cardiology procedures. Due to his outstanding achievements in his field as well as his reputation as an excellent doctor he has the unique honor of being appointed as the Physician to the President of Islamic Republic of Pakistan.', '1770199677_doc2.jpg', '+92 317 1777509', 'ahmed.usman@eum.edu.pk', 'Satayana Rd, D Ground Block B People\'s Colony No 1, Faisalabad', '20', '1k+', '5', 'University Malaysia Sarawak (UNIMAS)', 'English, Urdu', '12.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"03:00 - 06:00\",\"location\":\"Integrated Medical Care (IMC) Hospital, Lahore\"},\"Tuesday\":{\"time\":\"03:00 - 06:00\",\"location\":\"Integrated Medical Care (IMC) Hospital, Lahore\"},\"Wednesday\":{\"time\":\"03:00 - 06:00\",\"location\":\"Integrated Medical Care (IMC) Hospital, Lahore\"},\"Thursday\":{\"time\":\"03:00 - 06:00\",\"location\":\"Integrated Medical Care (IMC) Hospital, Lahore\"},\"Friday\":{\"time\":\"03:00 - 06:00\",\"location\":\"Integrated Medical Care (IMC) Hospital, Lahore\"},\"Saturday\":{\"time\":\"03:00 - 06:00\",\"location\":\"Integrated Medical Care (IMC) Hospital, Lahore\"},\"Sunday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"}}'),
(3, 'Dr. Faisal Ahmed Zaeem', 'Urology', 'Dr. Faisal Ahmed Zaeem graduated from State Medical University, Volgograd, Russia with the award of MD. Masters In Urology from Punjab University, Lahore. Registered with Pakistan Medical Commission. Trained in urology at Sir Ganga Ram Hospital, Lahore. Member Pakistan Association of Urological Surgeons. Working as a consultant Urologist in Sir Ganga Ram Hospital. Visiting Consultant Urologist at Horizon Hospital, Johar Town Lahore. Visiting Consultant Urologist at Islamabad Diagnostic Center, Jail Road, Lahore.', '1770613717_doc3.jpg', '+92 304 0035050', 'info@drzaeem.com', 'IDC Shadman Jail Road Lahore, Horizon hospital johar town lahore, City Hospital Jail Chowk Gujrat, AMC Ghazi Chak GT Road Gujrat', '19', '1k+', '5', 'State Medical University, Volgograd', 'English, Urdu', '20.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"02:00 - 04:00, 04:00 - 06:00\",\"location\":\"In IDC Shadman, In Horizon hospital\"},\"Tuesday\":{\"time\":\"02:00 - 04:00, 04:00 - 06:00\",\"location\":\"In IDC Shadman, In Horizon hospital\"},\"Wednesday\":{\"time\":\"02:00 - 04:00, 04:00 - 06:00\",\"location\":\"In IDC Shadman, In Horizon hospital\"},\"Thursday\":{\"time\":\"02:00 - 04:00, 04:00 - 06:00\",\"location\":\"In IDC Shadman, In Horizon hospital\"},\"Friday\":{\"time\":\"02:00 - 04:00, 04:00 - 06:00\",\"location\":\"In IDC Shadman, In Horizon hospital\"},\"Saturday\":{\"time\":\"06:00 - 09:00, 03:00 - 05:00\",\"location\":\"In City Hospital, In AMC Ghazi\"},\"Sunday\":{\"time\":\"06:00 - 09:00, 03:00 - 05:00\",\"location\":\"In City Hospital, In AMC Ghazi\"}}'),
(5, 'Dr. M. Ramzan Chaudhry', 'Urology', 'Brig.(R) Dr. Muhammad Ramzan Ch. is an expert andrologist and sexologist, practicing in Lahore. Specializing in male health, Dr. Ramzan is one of the most sought-after doctors in the city. With 42 years of (clinical) experience in urological and andrological procedures and surgeries, Brig.(R) Dr. Muhammad Ramzan Ch. has also served in the administrative capacity in Pakistan Army. A member of the Pakistan Medical Commission (PMC), he is currently serving as an Assistant Professor at the Shalamar Medical College as well.', '1770614196_doc4.jpg', '+92 321 4259342', 'ramzan.muhammad@uos.edu.pk', 'Dr Rukhsana Manzoor Zafar, Best Gynaecologist, Infertility specialist, Laparoscopic Surgeon, New Muslim Town Abu Bakar Block Garden Town, Lahore, Baba-e-Homeopathy Dr. Hamid\'s National Homeo Stores, Khursheed plaza, basement D.H.A. Main Blvd, Defence, Lahore, 54810', '47', '1k+', '5', 'University of Karachi, Pakistan', 'English, Urdu', '12.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"09:30 - 01:00, 01:30 - 02:30\",\"location\":\"In Hameed Latif Hospital, In Rasheed Hospital (DHA)\"},\"Tuesday\":{\"time\":\"09:30 - 01:00, 01:30 - 02:30\",\"location\":\"In Hameed Latif Hospital, In Rasheed Hospital (DHA)\"},\"Wednesday\":{\"time\":\"09:30 - 01:00, 01:30 - 02:30\",\"location\":\"In Hameed Latif Hospital, In Rasheed Hospital (DHA)\"},\"Thursday\":{\"time\":\"09:30 - 01:00, 01:30 - 02:30\",\"location\":\"In Hameed Latif Hospital, In Rasheed Hospital (DHA)\"},\"Friday\":{\"time\":\"09:30 - 12:00, 02:30 - 03:00\",\"location\":\"In Hameed Latif Hospital, In Rasheed Hospital (DHA)\"},\"Saturday\":{\"time\":\"09:30 - 01:00, 01:30 - 02:30\",\"location\":\"In Hameed Latif Hospital, In Rasheed Hospital (DHA)\"},\"Sunday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"}}'),
(6, 'Prof. Dr. Sajjad Naseer', 'Neurology', 'Dr. Sajjad Naseer is a Consultant (Neurologist) practicing at Neuro Diagnostics, Lahore. He is specialist in treating neuropathies, migraine, general pediatric neurology and neuromuscular rehabilitation. He has an experience of 30 years in his field. He has done MBBS from Punjab University, later on, he did FCPS (Neurology) from College of Physicians and Surgeons Pakistan, MRCP (General Medicine) from RCP Ireland and then MRCPS from Glasgow, FAAN from Fellow of the American Academy of Neurology and American Board of Electro Diagnostic Medicine From USA.', '1770614515_doc5.jpg', '+92 335 4839629', 'marham@gmail.pk', 'Dr. Sajjad Naseer Clinic (Lahore), Islamabad Specialists Clinic (F-8 ISC) (Islamabad)', '30', '1k+', '5', 'MBBS - King Edward Medical University, 1987', 'English, Urdu', '10.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"06:00 - 08:30\",\"location\":\"In Block J DHA EME Sector, Lahore\"},\"Tuesday\":{\"time\":\"06:00 - 08:30\",\"location\":\"In Block J DHA EME Sector, Lahore\"},\"Wednesday\":{\"time\":\"06:00 - 08:30\",\"location\":\"In Block J DHA EME Sector, Lahore\"},\"Thursday\":{\"time\":\"06:00 - 08:30\",\"location\":\"In Block J DHA EME Sector, Lahore\"},\"Friday\":{\"time\":\"06:00 - 08:30\",\"location\":\"In Block J DHA EME Sector, Lahore\"},\"Saturday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"},\"Sunday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"}}'),
(8, 'Prof. Dr. Shahid Mukhtar', 'Neurology', 'Assoc. Prof. Dr. Shahid Mukhtar is one of the best neurologists in Lahore. He is very active in his field, and has his own blog as well, which carries informative articles that help people gain knowledge about the neurological issues that affect the public.', '1770615655_doc6.png', '+92 300 4542015', 'smukhtar@uab.edu', 'Leopards courier, Shop # 2, Main Blvd Allama Iqbal Town, near Farooq Hospital, Asif Block Allama Iqbal Town, Lahore, Dr Ammara Iqbal, Sadiq Hospital, 24-A Main Satellite Town Rd, Sgd, Sargodha, House Cleaning Services Lahore, Avenue Mall P Block, DHA, Main Ghazi Rd, near Rehman Gardens, Rehman Gardens Lahore', '35', '1k+', '5', 'Department of Genetics and Biochemistry at Clemson University', 'English, Urdu', '15.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"08:30 - 10:30, 04:00 - 06:00\",\"location\":\"In Farooq Hospital, In Farooq Hospital (DHA)\"},\"Tuesday\":{\"time\":\"08:30 - 10:30, 04:00 - 06:00\",\"location\":\"In Farooq Hospital, In Farooq Hospital (DHA)\"},\"Wednesday\":{\"time\":\"08:30 - 10:30, 04:00 - 06:00\",\"location\":\"In Farooq Hospital, In Farooq Hospital (DHA)\"},\"Thursday\":{\"time\":\"08:30 - 10:30, 04:00 - 06:00\",\"location\":\"In Farooq Hospital, In Farooq Hospital (DHA)\"},\"Friday\":{\"time\":\"08:30 - 10:30, 04:00 - 06:00\",\"location\":\"In Farooq Hospital, In Farooq Hospital (DHA)\"},\"Saturday\":{\"time\":\"08:00 - 10:00\",\"location\":\"In Sadiq Hospital (SGD)\"},\"Sunday\":{\"time\":\"08:00 - 10:00\",\"location\":\"In Sadiq Hospital (SGD)\"}}'),
(9, 'Dr. Shahbaz Ahmed Qazi', 'Ultrasound', 'Dr. Shahbaz Ahmed Qazi is a European board certified interventional radiologist. He has been trained and specialized in minimally invasive procedures from the USA, UK and various centers of Europe. Currently he is working as a consultant vascular interventional radiologist in National Guards Health Affairs Riyadh, a prestigious tertiary care center and largest interventional radiology setup in the middle east. He has over 20 years of experience working as a vascular interventional radiologist. He has been using the latest technological innovations in his regular IR Practice especially vascular interventions. He has been a clinician trainer and faculty at various medical training conferences – Pakistan and abroad. He has to his credit several publications and presentations in various Medical Journals. Dr Shahbaz Ahmed Qazi is a founder and director of VIC (Vascular and Interventional Courses) an academic professional group conducting interventional radiology courses workshops and symposium in Pakistan. He is currently involved in various tumor board meetings and grand rounds.', '1770622793_doc8.jpg', '+92 300 7693048', 'shahbazvirk@ntu.edu.pk', 'Shahbaz Clinic, Sargodha Road, Block B, Muslim Town, Faisalabad', '20', '1k+', '5', 'Bachelor of Medicine (MBBS) Sindh Medical College Karachi 1994', '', '10.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"},\"Tuesday\":{\"time\":\"08:00 - 10:00\",\"location\":\"In Shahbaz Clinic\"},\"Wednesday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"},\"Thursday\":{\"time\":\"08:00 - 10:00\",\"location\":\"In Shahbaz Clinic\"},\"Friday\":{\"time\":\"08:00 - 10:00\",\"location\":\"In Shahbaz Clinic\"},\"Saturday\":{\"time\":\"08:00 - 10:00\",\"location\":\"In Shahbaz Clinic\"},\"Sunday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"}}'),
(10, 'Prof. Dr. Joharia Azhar\"', 'Dentist', 'Prof. Dr Joharia Azhar is a Professor in Oral pathology & medical education, a consultant laser dentist, cosmetologist, and aesthetic physician. One of the pioneers of Laser dentistry and Laser assisted Pain control clinics, she has practiced in and around Rawalpindi and Islamabad since 2005. She established and introduced her exclusive laser dentistry and laser pain control clinics in 2011, which were later expanded into Pathodont Polyclinics. She is a recipient of the “first President’s bussiness women awards 2022” bestowed by Dr Arif Alvi, President of Pakistan.', '1770622967_doc9.jpg', '+92 316 5366657', 'joharia@edu.pk', 'Street 1, Dad Khan Avenue, Bostan Khan Road, Behind Shell Pump, Chaklala Scheme 3, Rawalpindi, Pakistan', '21', '1k+', '5', '(Oral Pathology) from Queen Mary University, London', 'English, Urdu', '13.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"11:00 - 09:00\",\"location\":\"Joharia Clinic\"},\"Tuesday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"},\"Wednesday\":{\"time\":\"11:00 - 09:00\",\"location\":\"Joharia Clinic\"},\"Thursday\":{\"time\":\"11:00 - 09:00\",\"location\":\"Joharia Clinic\"},\"Friday\":{\"time\":\"11:00 - 09:00\",\"location\":\"Joharia Clinic\"},\"Saturday\":{\"time\":\"11:00 - 09:00\",\"location\":\"Joharia Clinic\"},\"Sunday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"}}'),
(11, 'Prof. Dr. Nusrat Sharif', 'Ophthalmology', 'Prof. Dr. Nusrat Sharif is an expert Pediatric Ophthalmologist with 24 years of experience.', '1770623150_doc10.jpg', '+92 333 1579131', 'drnusratsharif@gmail.pk', 'Al-Shifa Trust Eye Hospital, Grand Trunk Road, Rawalpindi', '24', '1k+', '5', 'MBBS - Quaid-e-Azam Medical College', 'English, Urdu', '4.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"06:00 - 10:00\",\"location\":\"Al-Shifa Trust Eye Hospital\"},\"Tuesday\":{\"time\":\"06:00 - 10:00\",\"location\":\"Al-Shifa Trust Eye Hospital\"},\"Wednesday\":{\"time\":\"06:00 - 10:00\",\"location\":\"Al-Shifa Trust Eye Hospital\"},\"Thursday\":{\"time\":\"06:00 - 10:00\",\"location\":\"Al-Shifa Trust Eye Hospital\"},\"Friday\":{\"time\":\"06:00 - 10:00\",\"location\":\"Al-Shifa Trust Eye Hospital\"},\"Saturday\":{\"time\":\"06:00 - 10:00\",\"location\":\"Al-Shifa Trust Eye Hospital\"},\"Sunday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"}}'),
(12, 'Prof. Dr. Syed Owais Ahmed', 'Pathologist', 'Prof. Dr. Syed Owais Ahmed is a highly distinguished and experienced medical professional specializing in Infectious Diseases and Pathology. He is currently serving as a Professor at Al-Tibri Medical College and Hospital (part of Isra University), located in Gadap Town, Karachi. With a career spanning over 42 years, he is recognized as one of the leading experts in his field in Pakistan, particularly for his expertise in managing complex infections and pulmonary condition.', '1770623292_doc11.jpg', '+92 311 1222398', 'ahmadowais@gmail.com', 'Al-Tibri Medical College And Hospital, Gadap Town, Karachi', '42', '1k+', '5', 'MBBS from Sindh University', 'English, Urdu', '15.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"04:00 - 10:00\",\"location\":\"Medical College And Hospital\"},\"Tuesday\":{\"time\":\"04:00 - 10:00\",\"location\":\"Medical College And Hospital\"},\"Wednesday\":{\"time\":\"04:00 - 10:00\",\"location\":\"Medical College And Hospital\"},\"Thursday\":{\"time\":\"04:00 - 10:00\",\"location\":\"Medical College And Hospital\"},\"Friday\":{\"time\":\"04:00 - 10:00\",\"location\":\"Medical College And Hospital\"},\"Saturday\":{\"time\":\"04:00 - 10:00\",\"location\":\"Medical College And Hospital\"},\"Sunday\":{\"time\":\"04:00 - 10:00\",\"location\":\"Medical College And Hospital\"}}'),
(13, 'Dr. Rizwan Arshad', 'Orthopedic', 'Dr. Rizwan Arshad is a highly respected and experienced Orthopedic Surgeon in Sargodha, Pakistan, providing expert medical care through in-clinic and online consultations. Patients can book an appointment by calling 042-32377001. With a strong commitment to patient care, Dr. Rizwan Arshad delivers a personalized, ethical, and accessible healthcare experience through the Apka Muaalij digital healthcare platform. His empathetic communication style and clinical expertise help patients feel confident and comfortable throughout their healthcare journey.', '1770624218_doc7.jpg', '042 32377001', 'rizwan.arshad@dnsc.uol.edu.pk', 'Niazi Medical Complex, Club Road, Sargodha', '15', '1k+', '5', 'FCPS Orthopaedic Surgery , MBBS', 'English, Urdu', '5.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"11:00 - 04:00\",\"location\":\"Niazi Medical Complex\"},\"Tuesday\":{\"time\":\"11:00 - 04:00\",\"location\":\"Niazi Medical Complex\"},\"Wednesday\":{\"time\":\"11:00 - 04:00\",\"location\":\"Niazi Medical Complex\"},\"Thursday\":{\"time\":\"11:00 - 04:00\",\"location\":\"Niazi Medical Complex\"},\"Friday\":{\"time\":\"11:00 - 04:00\",\"location\":\"Niazi Medical Complex\"},\"Saturday\":{\"time\":\"11:00 - 04:00\",\"location\":\"Niazi Medical Complex\"},\"Sunday\":{\"time\":\"No Time Today\",\"location\":\"Clinic Closed\"}}'),
(14, 'Dr. Maria Saigol', 'Diabetologist', 'Dr. Maria Saigol is a top Diabetologist with 18 years of experience currently practicing at Chughtai Medical Center (DD), Lahore. In order to book an appointment with Dr. Maria Saigol you can call 04238900939 or click the Book Appointment button.', '1770626948_doc12.jpg', ' +92 309 2227770, 04238900939', 'saigol@gmail.pk', 'Chughtai Medical Center (DD), Diabetes Wellness Center', '18', '1k+', '5', 'M.B.B.S - King Edward Medical University, 2001', 'English, Urdu', '10.00', 'Available Now', '4.5', '{\"Monday\":{\"time\":\"12:30 - 02:00, 05:30 - 07:00\",\"location\":\"Chughtai Medical Center, Diabetes Wellness Center\"},\"Tuesday\":{\"time\":\"12:30 - 02:00, 05:30 - 07:00\",\"location\":\"Chughtai Medical Center, Diabetes Wellness Center\"},\"Wednesday\":{\"time\":\"12:30 - 02:00, 05:30 - 07:00\",\"location\":\"Chughtai Medical Center, Diabetes Wellness Center\"},\"Thursday\":{\"time\":\"12:30 - 02:00, 05:30 - 07:00\",\"location\":\"Chughtai Medical Center, Diabetes Wellness Center\"},\"Friday\":{\"time\":\"12:30 - 02:00, 05:30 - 07:00\",\"location\":\"Chughtai Medical Center, Diabetes Wellness Center\"},\"Saturday\":{\"time\":\"05:30 - 07:00\",\"location\":\"Diabetes Wellness Center\"},\"Sunday\":{\"time\":\"05:30 - 07:00\",\"location\":\"Diabetes Wellness Center\"}}');

-- --------------------------------------------------------

--
-- Table structure for table `footer_settings`
--

CREATE TABLE `footer_settings` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `brand_description` text DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `tw_link` varchar(255) DEFAULT NULL,
  `inst_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer_settings`
--

INSERT INTO `footer_settings` (`id`, `brand_name`, `brand_description`, `fb_link`, `tw_link`, `inst_link`) VALUES
(1, 'GlucoCare', 'Your trusted partner for online doctor consultations.', 'www.facebook.com', 'www.Twitter.com', 'www.Instagram .com');

-- --------------------------------------------------------

--
-- Table structure for table `hero_settings`
--

CREATE TABLE `hero_settings` (
  `id` int(11) NOT NULL,
  `badge_text` varchar(255) DEFAULT NULL,
  `main_title` varchar(255) DEFAULT NULL,
  `highlight_title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `float1_main` varchar(100) DEFAULT NULL,
  `float1_sub` varchar(100) DEFAULT NULL,
  `float2_main` varchar(100) DEFAULT NULL,
  `float2_sub` varchar(100) DEFAULT NULL,
  `btn1_text` varchar(100) DEFAULT NULL,
  `btn1_link` varchar(255) DEFAULT NULL,
  `btn2_text` varchar(100) DEFAULT NULL,
  `btn2_link` varchar(255) DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `stat1_val` varchar(50) DEFAULT NULL,
  `stat1_label` varchar(100) DEFAULT NULL,
  `stat2_val` varchar(50) DEFAULT NULL,
  `stat2_label` varchar(100) DEFAULT NULL,
  `stat3_val` varchar(50) DEFAULT NULL,
  `stat3_label` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_settings`
--

INSERT INTO `hero_settings` (`id`, `badge_text`, `main_title`, `highlight_title`, `description`, `float1_main`, `float1_sub`, `float2_main`, `float2_sub`, `btn1_text`, `btn1_link`, `btn2_text`, `btn2_link`, `hero_image`, `stat1_val`, `stat1_label`, `stat2_val`, `stat2_label`, `stat3_val`, `stat3_label`) VALUES
(1, '5K+ Happy Patients Every Month', 'Premium Healthcare: Find Your Trusted', 'Doctors Today', 'Skip the waiting room. Connect with class specialists instantly. Professional medical care is now just one click away.', 'Smart Solutions', 'Verified', 'Guaranteed Care', 'Top Rated Experts', 'Book Appointment', '#doctors', 'Explore Specialities', '#specialities', '1773642671_banner-doctor-1.png', '1.5K+', 'Doctors', '100%', 'Secure', '24/7', 'Support');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_info`
--

CREATE TABLE `site_info` (
  `id` int(11) NOT NULL,
  `info_type` varchar(50) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_info`
--

INSERT INTO `site_info` (`id`, `info_type`, `content`, `icon`) VALUES
(1, 'WhatsApp Phone', '+92 304 4904000', 'fab fa-whatsapp'),
(2, 'Calling Number Phone', '+1 206 2109118', 'fas fa-phone'),
(3, 'Primary Email Email', 'pulse@logix.edu.pk', 'fas fa-envelope'),
(4, 'Website Link', 'https://glucocare.com/', 'fas fa-globe'),
(5, 'Main Office Location', 'Club Road, Shama Chowk, Sargodha, Pakistan', 'fas fa-map-marker-alt'),
(15, 'Branch Office Location', '5900 Balcones Dr # 17964, Austin, Taxas, 78731, USA', 'fas fa-map-marker-alt');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) DEFAULT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('logo','link','text') DEFAULT 'text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_type`) VALUES
(2, 'site_title', 'GluCo', 'text'),
(3, 'nav_Home', 'index.php', 'link'),
(4, 'nav_Doctors', '#doctors', 'link'),
(5, 'nav_Specialities', '#specialities', 'link'),
(6, 'nav_Blog', '#blog', 'link'),
(7, 'nav_Contact', '#contact', 'link');

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `id` int(11) NOT NULL,
  `spec_name` varchar(100) NOT NULL,
  `spec_icon` varchar(100) NOT NULL,
  `spec_color` varchar(50) DEFAULT 'blue'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `spec_name`, `spec_icon`, `spec_color`) VALUES
(1, 'Cardiology', 'fas fa-heartbeat', 'red'),
(2, 'Urology', 'fas fa-notes-medical', 'blue'),
(3, 'Neurology', 'fas fa-brain', 'purple'),
(4, 'Orthopedic', 'fas fa-bone', 'green'),
(5, 'Ultrasound', 'fas fa-wave-square', 'orange'),
(6, 'Dentist', 'fas fa-tooth', 'red'),
(7, 'Ophthalmology', 'fas fa-eye', 'blue'),
(8, 'Pathologist ', 'fas fa-microscope', 'purple'),
(9, 'Diabetologist', 'fas fa-tint', 'green');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `appliance_settings`
--
ALTER TABLE `appliance_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_settings`
--
ALTER TABLE `footer_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_settings`
--
ALTER TABLE `hero_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `site_info`
--
ALTER TABLE `site_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `specialties`
--
ALTER TABLE `specialties`
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
-- AUTO_INCREMENT for table `appliance_settings`
--
ALTER TABLE `appliance_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `hero_settings`
--
ALTER TABLE `hero_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_info`
--
ALTER TABLE `site_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `specialties`
--
ALTER TABLE `specialties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
