-- MariaDB dump 10.17  Distrib 10.4.8-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bucte_db
-- ------------------------------------------------------
-- Server version	10.4.8-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `doc_type` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_format` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `folder` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('present','archived') COLLATE utf8_unicode_ci DEFAULT 'present',
  `uploaded_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`doc_id`),
  KEY `FK` (`u_id`),
  CONSTRAINT `doc_to_user_fk` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
INSERT INTO `document` VALUES (28,'CTE000001','test','','file_20191218080656.pptx','records','presentation','2019-12',NULL,'present','2019-12-18 08:06:56'),(29,'CTE000001','another one','another one','file_20191224105042.pdf','records','pdf','2019-12',NULL,'present','2019-12-24 10:50:44'),(30,'CTE000001','fsdfsdfsfsfsdf','fdasdasdasdasdasd','file_20200101105823.xlsx','records','spreadsheet','2020-01',NULL,'present','2020-01-01 22:58:23'),(31,'CTE000001','testttttttt','testttttttt','file_20200101110525.txt','records','text','2020-01',NULL,'present','2020-01-01 23:05:25'),(32,'CTE000001','oiuiiuioiu','oiuiiuioiu','file_20200101111934.docx','records','word','2020-01',NULL,'present','2020-01-01 23:19:34'),(33,'CTE000001','Title','Descrdfsdf','file_20200104050510.ppsx','records','presentation','2020-01',NULL,'present','2020-01-04 17:05:10'),(34,'CTE000001','adasdasdasd','asdasd','file_20200127062754.png','records','image','2020-01',NULL,'present','2020-01-27 18:27:54');
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `evnt_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `sched` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `venue` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`evnt_id`),
  KEY `u_id` (`u_id`),
  CONSTRAINT `events_to_user_fk` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (8,'CTE000001','','asdasdasd','2020-02-27','asdasdasd','<p>xzczxczxczx</p>\r\n','2020-02-27 21:17:41'),(9,'CTE000001','file_20200301120720.jpg','asdasd','2020-03-01','qweqwe','<p>zxczxc</p>\r\n','2020-03-01 00:07:20'),(10,'CTE000001','file_20200301121154.jpg','asd','2020-03-01','qwe','<p>zxc</p>\r\n','2020-03-01 00:11:54');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_privilege`
--

DROP TABLE IF EXISTS `page_privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_privilege` (
  `pgpriv_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `page` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `privilege` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`pgpriv_id`),
  KEY `u_id` (`u_id`),
  CONSTRAINT `pgpriv_to_user_fk` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='privileges for pages\r\n(for every Page: specify each with a descriptive name and always include comments with php filename)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_privilege`
--

LOCK TABLES `page_privilege` WRITE;
/*!40000 ALTER TABLE `page_privilege` DISABLE KEYS */;
/*!40000 ALTER TABLE `page_privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaire`
--

DROP TABLE IF EXISTS `questionnaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaire` (
  `qstn_id` int(11) NOT NULL AUTO_INCREMENT,
  `rvwr_id` int(11) NOT NULL,
  `question` longtext COLLATE utf8_unicode_ci NOT NULL,
  `optionA` longtext COLLATE utf8_unicode_ci NOT NULL,
  `optionB` longtext COLLATE utf8_unicode_ci NOT NULL,
  `optionC` longtext COLLATE utf8_unicode_ci NOT NULL,
  `optionD` longtext COLLATE utf8_unicode_ci NOT NULL,
  `answer` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`qstn_id`),
  KEY `rvwr_id` (`rvwr_id`),
  CONSTRAINT `questionnaire_to_reviewer_fk` FOREIGN KEY (`rvwr_id`) REFERENCES `reviewer` (`rvwr_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='e-let reviewer questions';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire`
--

LOCK TABLES `questionnaire` WRITE;
/*!40000 ALTER TABLE `questionnaire` DISABLE KEYS */;
INSERT INTO `questionnaire` VALUES (40,128,'1','True','False','','','b'),(41,128,'2','qweqwe','asdasdasd','zxczxczxc','','a'),(46,128,'asadasdasd','aasdad','sdzxczxc','','','a'),(58,128,'asdasdasd```','asdasdasd','asdasd','','','a'),(66,131,'Melinda advised, \"Have a good bank account, a good cook and good digestion.\" What is being refered to?','Duty','Family','Security','Investment','c'),(67,131,'She describes her classmate\'s statement as too SOPHOMORIC. This means _____________.','Grown up','Mature','Immature','Wise','c'),(69,131,'Which does NOT mean the same as the other three?','Defend','Supply','Equip','Furnish','a'),(70,131,'“Nothing happens in this world ever happens by chance; it is all part of a grand design”. The author speaks of one’s _________.','luck','destiny','dream','ambition','b'),(71,131,'After 10 unfruitful years, Fe finally quit the job. She ______ along with her boss for a long time.','didn’t get','hasn’t been getting','hadn’t been getting','isn’t getting','b'),(75,131,'Choose the sentence that expresses the thought clearly and that has no error in structure/spelling.','The farmer did plow, plant, harvest his corn in record time.','The farmer plowed, planted, and harvested his corn in record time.','The farmer plowed, planted and has harvested his corn in record time.','The farmer has plowed, planted and harvested his corn in record time.','d'),(76,131,'Who said, “The Filipino is worth dying for?”','Carlos P. Garcia','Benigno Aquino','Fidel V. Ramos','Jose P. Rizal','b'),(77,131,'Who is remembered for his famous quotation?\r\n“My loyalty to my party ends where my loyalty to my country begins.”','Ferdinand Marcos ','Manuel Quezon','Manuel Roxas','Carlos P. Garcia','b'),(78,131,'Which of the theories learning, language and literacy view children as having the ability to organize and integrate information in schemata?','Reader Response','Interactive','Sociolinguistic','Constructivist','d'),(79,131,'Sometimes I am very much tempted to believe that one reason why so many people don’t do anything for their “less fortune” brother is _____ hold your breath ______ television. (And while you are it, you might as well hold your disbelief for a while, too.) We have lived with television for so long that, without our knowing it, it has changed our way of looking at life. It used to be that people look at life as if it were television.\r\n                    - Johnny C. Go (Because There’s  a TV Set in the Living Room)\r\nThe author is blaming TV sets for people nowadays ________.','Watch TV programs almost the entire day 	','Look at reality as if it were a TV program','Watched TV programs and hold their disbelief in life	','Pretend that TV programs are realities','b'),(80,131,'Which of the following BEST restates the meaning of “The child is the father of the man.”','Children are naturally wiser than adults','If there would be no children, there would be no fathers','The experiences and lessons of childhood influence one’s adult life','Fathers are dependent on the sight of their children','c'),(81,131,'Sa taas ng mga bilihin ngayon, kahit “kahig ka ng kahig” ay wala pa ring maipon. Ano ang ibig sabihin nito?','Bawasan ang bili','Hanap ng hanap','Gastos ng gastos','Hindi bumili','b'),(82,131,'Manunulat ang tatay ko kaya sa personal mong kagustuhan makasunod sa kanyang mga yapak, magsulat ka. Ano ang kahulugan ng pag-susulat?','Maklikha ng mga salita, pangungusap, at talata ','Kakayahan ng tao na malinaw na makapagtala o makapag-imprenta','Pagpili ng paksa at pagsasaliksik','Proseso na nagsisimula sa idea o karanasan','d'),(83,131,'“Matagal ng lumagay sa tahimik si Mely”. Ang ibig sabihin ay:\r\n','Lumisan na','Nanahimik na','Nag-asawa na','Namatay na','c'),(84,131,'I. Ang kahoy ay nilalagare sa katamtamang laki, at saka pinuputol sa maraming pirasong hugis rektanggulo. II. Ang pagkikinis ay nangangailangan ng isang bihasa, sapagka’t totoong mapanganib at sa sandaling sumala ma amh matalim na kasangkapan sa bakya, ang magiging bunga ay matinding hiwa sa hita ng tagakinis. III. Ang mga kahoy na ginagamit sa paggawa ng bakya’y nanggagaling sa Quezon, Zambales at Bataan. Ang wastong pagkakasunod-sunod ng mga pangungusap ay makikita sa ________.','II, III at I','III, I at II','I, II at III','III, II at I','b'),(85,131,'Alin ang salawikain sa mga sumusunod:','Di maliparang uwak.','May puno walang bunga, may dahon walag sanga.','Nagbubuhat ng sariling bangko.','Nasa Diyos ang awa, nasa tao ang gawa.','d'),(86,131,'Alin sa mga ito ang nagpapahayag sa paraang organisado at artistiko maging tuluyan o sa berso na nagmula sa imahinasyon?','Panitikan','Panuluan','Sanaysay','Epiko','a'),(87,131,'Mag-aalas singko na ______ umaga _______ magising sya.\r\n','ng-at','nang-nang ','ng-nang','nang-kapag','c'),(88,131,'Kung ang awit ng pag-iibigan ay kundiman, ano naman sa Bisaya?','Kumintang','Sambotani','Dioma','Talindaw','d'),(89,131,'The vertex angle of an isosceles triangle is 30 deg. What is the measure of one of the base angles?\r\n','70°','75°','150°','60°','b'),(90,131,'Which of these has a value different from the other three?\r\n','15	','12/75','3/20','15%','b'),(91,131,'How many glasses of Cola each to be filled with 150 cu.cm of the liquid can be made from 5 family-size bottles of Cola each containing 1.5 liters?\r\n','60 ','45','50','40','c'),(92,131,'Between January 2008 and August 2008, the price of gasoline rose from 28.40 to 52.90 per liter. What is the percent of the increase over the 8-month period?','97.5%','86.27%','46.81.81%',' 24.5%','b'),(93,131,'A car depreciates by 10% of its brand new price each year and by 15% in each succeeding year. By 2009, what would be the market price for a car bought brand new for P 6 depreciates by 10% of its brand new price each year and by 15% in each succeeding year. By 2009, what would be the market price for a car bought brand new for P 600, 000 in 2004?			','P 420, 000','P 390, 000','P 480, 000',' P 210,000','d'),(94,131,'A child can be admitted to Grade 1 if he/she is at least 5 years and 10 months old by June of the school year. Which of these dates of birth will be DISQUALIFY a child from being admitted to Grade 1 on June 15, 2009?','June 10, 2003','Jan. 10, 2003','April 30, 2003','May 5, 2003','a'),(95,131,'Which of these numbers CANNOT possibly be a square number? Should be CAN','10217356','2916488','35366809','262758','c'),(96,131,'Which number is wrong in the sequence? What should the number be for the sequence to be CORRECT? 5, 15, 16, 48, 144, 147, 148, 444 ….','144; it should be 29	','144; it should be 132.','48; it should be 18','147; it should be 145','d'),(97,131,'The prevailing wind systems experienced in the Philippines are __________.','Northwest and Southeast monsoon','North and South monsoon','East and West monsoon','Northeast and Southwest monsoon ','d'),(98,131,'You inherited tallness from your father. Physical traits are transmitted from parents to offspring through __________.','Gametes','Genes','Chromosome','Alleles','c'),(99,131,'When you carry a heavy load with one arm, you tend to hold your free hand away from your body in order to ____________.','Change the weight of your body and load','Change the mass of your body','Change the center of the gravity of your body and load.','Be ready to grab something in case you fall','a'),(100,131,'Jane placed some mothballs inside her cabinet. After a week they were all gone. What happened to the mothballs?','They condensed','They melted','They were dissolved by water in the air.','They sublimed ','d'),(101,131,'Why do we hear thunder some seconds after seeing lightning?','Sound travels 1,331 m/s','Sound is released later actually','Light appears brighter in the sky.','Light travels faster than sound ','d'),(102,131,'What is the type of response exhibited by the roots of plants?','Negative phototropism','Positive geotropism','Positive Thigmotropism','Negative geotropism','b'),(103,131,'All the following problems may arise in the use of sanitary landfill, EXCEPT:','Production of methane gas and possible explosion','Refusal of residents for the construction of a sanitary landfills in their area.','Pollution of the surrounding soil','Flashfloods and degradation of soil','a'),(104,131,'Violation of human rights is a violation of the ______ of persons.','Emotions	','Dignity','Freedom','Intelligence','b'),(105,131,'What is the primary concern of marriage?','The companionship and husband and wife','The maintenance of the social status','The procreation and education of children ','The mutual production and security of man and woman','a'),(106,131,'UNESCO is an international organization promoting which programs of the United Nations?','Competence, Science, Nature','National Unity, Science',' Education, Science, Culture','Unity, Organization, Education','c'),(107,131,'What does the phrase Cold war refer to?','Asia and Europe','The United States and its allies and then the Union of Soviet Socialist Republics and its allies','Japan and the Philippines','Germany and Great Britain','b'),(108,131,'What term best characterizes a peaceful community?','Harmony ','Spirituality','Tolerance','Ethics','c'),(109,131,'In peace education curricula, which does not belong?','Conflict resolution','Global Awareness','Interdependence among nations','Interdependence of nations','d'),(110,132,'With R.A 9155, to which body were all the functions, programs and activities of the Department of Education related to Sports competition transferred?','Technical Education Services Department Authority','Philippine Sports Commission','National Commission for Culture and the Arts','Commission on Higher Education','b'),(111,132,'To determine her students’ level of moral development, Teacher Evangeline presents to her class a morally ambiguous situation and asks them what they would do in such a situation. On whose theory is Teacher Evangeline’s technique based?','Bruner','Kohlberg','Freud','Piaget ','b'),(112,132,'According to R.A 9155, which among the following is considered the “heart of the formal education system”?','The pupil','The teacher','The classroom','The school','d'),(113,132,'You arrange the rows of blocks in such a way that a row of 5 blocks is longer than a row of 7 blocks. If you ask which row has more, Grade 1pupils will say that it is the row that makes the longer line. Based on Piaget’s cognitive development theory, what problem is illustrated?','Assimilation problem','Accommodation problem','Conservative problem','Egocentrism problem','c'),(114,132,'According to R.A 9155, a school head has two roles, namely administrative manager and _______.','Health Officer ','Instruction Leader','Facilitator','Guidance Counselor','b'),(115,132,'Which characterizes a constructivist teaching-learning process?','Conceptual inter-relatedness','Multiple perspectives','Authentic assessment','Passive acceptance of information','a'),(116,132,'On what theory is the sequencing of instruction anchored?','Gagne’s hierarchical theory','B.F Skinner’s operant conditioning theory','Bandura’s social learning theory	','Thorndike’s law of effect','a'),(117,132,'Based on Bandura’s theory, which conditions must be present for a student to learn from a model?\r\nI.	Attention		III. Motor reproduction\r\nII.	Retention		IV. Motivation','I and II','I, II and III','I, II, III and IV','III and IV','c'),(118,132,'According to Tolman’s theory on purposive behaviorism, learning is goal-directed. What is its implication to teaching?	','Evaluate lessons based on your objectives','Set as many objectives as you can	','Stick to your objective/s no matter what happens','Make the objective/s of your lesson clear and specific','a'),(119,132,'Which is the ideal stage of moral development? Stage of __________.','Social Contract','Universal Ethical Principle','Law and order','Good boy/good girl','b'),(120,132,'To help a student learn to the optimum, Vygotsky advises us to bridge the students\' present skill level and the desired skill level by','Challenging','Scaffolding ','Inspiring','Motivation','b'),(121,132,'Sassi, a Grade 1 pupil is asked, “Why do you pray every day?” Sassi answered, ”Mommy said so.” Based on Kohlberg’s theory, in which moral development stage is Sassi?','Pre-convention level','Conventional Level','In between conventional and post-conventional levels ','In between pre- and post-conventional levels','a'),(122,132,'It is good to give students creative learning tasks because of _______.	','Development is affected by cultural changes','The development of individuals is unique','Development is the individual’s choice	','Development is aided by stimulation','d'),(123,132,'According to Havighurst’s development tasks, reaching and maintaining satisfactory performance in one’s occupational career is supposed to have been attained during _______.','Middle age and Early adulthood','Middle age','Old age','Early adulthood','b'),(124,132,'In planning for instruction, can a teacher begin with assessment?','No, it may discourage and scare the learners','Yes, determine entry knowledge or skill','Yes, to make the class pay attention','No, assessment is only at the end of a lesson','b'),(125,132,'Which among the following is closest to the real human digestive system for study in the classroom?','Drawing of the human digestive system on the board	','Model of the human digestive system','The human digestive system projected on an OHP	','Drawing of the human digestive system on a page of a textbook','b'),(126,132,'Which one is in support of greater interaction?','Probing','Repeating the question','Not allowing a student to complete a response','Selecting the same student respondents','a'),(127,132,'I want to compare two concepts. Which technique is most appropriate?','Attribute wheel','K-W-L techniques','Venn diagram','Spider web organizer','c'),(128,132,'After establishing my learning objectives, what should I do to find out what my students know and what they do not yet know in relation to my lesson objectives in the cognitive domain?','Give a pretest','Study the least learned comprehensive in the National Achievement Test','Analyze my students’ grades last year','Interview a sample of my students','a'),(129,132,'At the end of my lesson on the role of a teacher in learning, I asked the class. “In what way is a teacher an enzyme? ” With this question, it engaged the class in ________.','Allegorical thinking','Concrete thinking','Metaphorical thinking','Symbolical thinking','c'),(130,132,'Is it advisable to use realias all the time?\r\n','No, for the sake of a variety of instructional materials','No, only when feasible','Yes, because there is no substitute for realias','Yes, because it is the real thing','a'),(131,132,'I used the gumamela flower; a complete flower, to teach the parts of a flower. Which method did I use?','Demonstration method','Type-study method','Drill method','Laboratory method','b'),(132,132,'Other than finding out how well the course competencies were met, Teacher Kathy also wants to know her students’ performance when compared with other students in the country. What is Teacher Kathy interested to do?','Formative evaluation','Authentic evaluation','Norm-referenced evaluation','Criterion-referenced evaluation','c'),(133,132,'“Do not cheat. Cheating does not pay. If you do, you cheat yourself” says the voiceless voice from within you. In the context of Freud’s theory, which is/are at work?	','Id','Id and Superego','Ego','Superego','d'),(134,132,'Cristina’s family had a family picture when she was not yet born. Unable to see herself in the family picture, she cried despite her mother’s explanation that she was not yet born when the family picture was taken. What does Cristina’s behavior show?','Limited social cognition','Egocentrism','Semi-logical reasoning	','Rigidity of thought','b'),(135,133,'Ano ang kahulugan ng salitang naglaon?','nagmadali','nagpunta','mabagal','nagtagal','d'),(136,133,'Sistematikong imbestigasyon at pag-aaral upang makabuo ng katotohanan at makarating sa bagong konklusyon.','pagpili ng paksa','pagsulat ng burador','pagrerebisa','talasanggunian','c'),(137,133,'Mabilisang pagbasa na ang layunin ay matukoy ang kabuuan ng isang akda sa halip na tingnan ang bawat tiyak na kaalaman.','Scanning','Previewing','Skimming','Pagbasa','c'),(138,133,'Uri ng pananaliksik na sumasakop lamang sa maliit na populasyon at layunin na itala ang bawat obserbasyon ng mga responsente upang matuloy and kalagayan.','Trend analysis','Case study','Documentary analysis','Experimental','b'),(139,133,'Ito ay tumutukoy sa mga morpemang inilalagay sa mga salitang-ugat.','malayang morpema','morpemang leksikal','morpemang di-malaya ','morpemang gramatikal','c'),(140,133,'Nakikiramay ako sa pagpanaw ng iyong ingkong. Ano ang tungkulin ng wika sa pahayag?','Imahinatibo','Heuristik','Personal ','Regulatori','c'),(141,133,'Alin sa mga sumusunod ang halimbawa ng sekundaryang pinagmulan ng impormasyon?	','Almanac','Documentary film','Diary','Audio-recording','a'),(142,133,'Ang mga salita na umaabot sa antas na kinikilalang opisyal na wika at ginagamit sa mga paaralan ay maituturing na ________.','Pampanitikan','Pambansa','Kolokyal','Balbal','b'),(143,133,'Ang bantas na hindi ginagamit sa pagsulat ng bibliography.','Tuldok','Tutuldok','Tildok-kawit','Kuwit','c'),(144,133,'Nakilala bilang “Ama ng Sarswelang Tagalog” at may akda sa dulang musical na “Walang Sugat”.','Aurelio Tolintino','Severino Reyes','Lope K. Santos','Jose Corazon De Jesus','b'),(145,133,'Isang mahabang pananalita na binibigkas ng isang karakter sa entablado na naglalaman ng kanyang saloobin at kaisipan.','Aside','Monologo','Soliloquy','Talumpati','b'),(146,133,'Kung bayani si Jose; Bayani din si Marcelo.','Payak','Tambalan','Hugnayan','Langkapan','c'),(147,133,'Alin sa grupo ng mga salita ang hindi kabilang?','hinangaan-pinuri','salot-sumpa','marikit-maganda','natalos-nalimutan','d'),(148,133,'_______ sa araw ng Sabado, ay naglilibot ang mag-anak. Ang nawawalang salita ay','Sa','Kung','Kapag','Simula','d'),(149,133,'Ito ang tawag sa unang pangungusap ng isang balita','Ulo','Pamatnubay','Kicker','Flash','b'),(150,133,'Piliin ang salitang walang diptonggo.','lamay','sapat','dumihin','marumi','b'),(151,133,'Ginalugad nila ang buong baryo, ngunit wala silang  nakita.','Hinanap','Sinilip','Iniharap','Ipinakita','a'),(152,133,'Alin sa mga sumusunod ang pangungusap?','Valentine’s Day na.','May tinapay.','Susmaryosep!','Lahat ng nabanggit','d'),(153,133,'Kung minsan ang kagandahan ay nasa kapangitan.','pagsasatao','pagmamalabis','pag-uyam','pagtatambis','d'),(154,133,'May mga pagkakataon na s aisang tingin pa lamang sa mata ng tao ay nakikita na ang mensahe gaya ng pagkindat.','proxemics','chronemics','haptics','oculesics','d'),(155,134,'The laborers are so happy that ________ now reaping the fruit _______ efforts.','they’re – their ','they’re – there ','there – their ','their – their ','a'),(156,134,'This seatwork is difficult for Paul and _______.','Myself','I','Me','Himself','c'),(157,134,'The candy care smells _____.','Sweet','Sweetly ','Sweeter','More sweet','a'),(158,134,'What is the biggest hindrance to learning a second language?','Grammar','Structure of language','Imagery','Cross-cultural issues','d'),(159,134,'Which among these words has [z] end sound?','Maps','Jokes','Laughs','Buys','d'),(160,134,'Rubric as a measuring instrument that is best use in assessing __________.','Sentence structure','Oral Recitation','Multiple choice Test','Dictation Test','b'),(161,134,'Who wrote the novel “Jungle Book” ','Victor Hugo','Rudyard Kipling','William March','K.L Mansfield','b'),(162,134,'This Victor Hugo’s Masterpiece that talks about the French revolution.','Les Miserables','Hunchback of Notre Dame','Annakarenina','Fathers and Sons','b'),(163,134,'A comma indicates:','Pause ','Slight pause','Longer pause','No pause','b'),(164,134,'What is not true about the present perfect tense?','The action started somewhere in the past and continued up until the present.','It must bear with it the auxiliary verb has/have plus the past participle form of the verb.','The action is still happening at present or just recently ended','The action is happening at present and may still happen in the future.','d'),(165,134,'Filipino as a He considered the father of the essay.','Michael de Montaigne','Francis Bacon','William Shakespeare','George Eliot','a'),(166,134,'Language Blossomed during Japanese occupation ________.','Japanese','American','Spanish','Commonwealth','a'),(167,134,'The Thomasites are ________.','Teachers from UST','Teachers form America','American Soldiers','Followers of St. Thomas','b'),(168,134,'A sonnet has 14 iambic pentameter lines and that means:','There are 10 syllables in a line','There are 5 syllables in a line','There are 8 syllables in a line','There are 11 syllables in a line','a'),(169,134,'Jose Rizal’s novel Noli Me Tangere is inspired by the novel written by Harriet Beecher Stowe titled __________.','Uncle Tom’s Cabin','Les Miserables','Tom Sawyer','War of the Roses','a'),(170,134,'It is a branch of linguistics that deals with how words combine to form phrases, phrases combine to form clauses, and clauses conjoin to make sentences.','Morphology','Syntax','Semantics','Pragmatics','b'),(171,134,'This type of language is used to describe the kind of language a learner uses at a given time, that is, his version of a given language, which deviates in certain ways from the language of a mature speaker.','Dialect	','Native language','Holophrastic speech','Interlanguage','d'),(172,134,'According to cognitivists, errors in second language learning is considered _________.','basis for testing','part of learning process','as proofs of unsystematic way of learning','not part of natural progression in acquisition of English','b'),(173,134,'What aptly describes “universal grammar”?','language used for communication by people who speak different first languages','rules applicable to all human languages','language with the same vocabulary, grammar and pronunciation','rules of grammar that distinguish one language from the others','b'),(174,134,'The following are the areas of knowledge and skills of communicative competence EXCEPT __________.','grammatical competence','sociolinguistic competence','discourse competence','structural competence','d'),(175,135,'The thousandths digit of the number 1,234.5678 is ________\r\n','1','7','8','5','b'),(176,135,'(4)(-6) + (12x3) = _______\r\n','10','12','14',' 15','b'),(177,135,'The difference between gross profit and cost of goods sold is known as __________.','Markdown','Discount','Net profit ','Invoice price','c'),(178,135,'Julius has ₱15,000 in the bank. After a year, he expects it to earn ₱750. What is the rate of interest?\r\n','2%','4%','5%',' 6%','c'),(179,135,'The greatest common divisor of 91, 39, and 78 is __________.\r\n','24 ','14 ','39','91','b'),(180,135,'The property of real numbers which describes (5+6)-3 = 3+(5+6) is __________.','Commutative','Associative','Distributive','Reflexive','a'),(181,135,'Which is proportion?','5:4 = 5:12','8:3 = 6:9','4:5 = 12:10 	','⅓:7 = 5:2','a'),(182,135,'1/8 in percent is ________.','10.5%','12.5%	','14.5%','16.5%','b'),(183,135,'John invested ₱5,000 in a certain business. How much will his money be in 2 years if it earns 12% in a year?\r\na.			b. 	c. d. \r\n','₱6,000','₱6,1000','₱6,200	','₱6,300','c'),(184,135,'What do you call an equality of 2 ratios?\r\n','quotient','fraction','percentage','proportion','d'),(185,135,'The number of hours spent for review in Algebra, Chemistry, and English is in ratio of 4:3:1. How many hours does each student spend for Chemistry in 24-hour review package?\r\n','3','6','9','12','c'),(186,135,'What is the value of 3.5 kilograms in grams?\r\n','35','350','3,500','35,000','c'),(187,135,'The least common multiple of 18 and 24 is ______.\r\n','6','24','36','72','d'),(188,135,'What do you call a triangle with equal sides?','Scalene','Isosceles','Equilateral','Right','b'),(189,135,'At 70 kph, Robin can reach his home within 50 minutes. At what rate should he drive his car so that he can reach home in 15 minutes?\r\n','60 kph','90 kph','80 kph','100 kph','d'),(190,135,'Qestion','True','False','','','a');
/*!40000 ALTER TABLE `questionnaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviewer`
--

DROP TABLE IF EXISTS `reviewer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviewer` (
  `rvwr_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `level` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`rvwr_id`),
  KEY `reviewer_to_user_fk` (`u_id`),
  CONSTRAINT `reviewer_to_user_fk` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='e-let reviewers';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviewer`
--

LOCK TABLES `reviewer` WRITE;
/*!40000 ALTER TABLE `reviewer` DISABLE KEYS */;
INSERT INTO `reviewer` VALUES (128,'CTE000001','Tig tetest ko yadi','Tig tetest ko yadi.','gen',120,'Tig tetest ko yadi.','2020-02-05 14:18:37'),(131,'CTE000002','General Education','www.letqa.blogspot.com','gen',120,'Goodluck!','2020-02-09 21:08:27'),(132,'CTE000002','Professional Education','www.letqa.blogspot.com','prof',45,'Fighting!','2020-02-10 22:59:13'),(133,'CTE000002','Filipino Education - Majorship','https://letqa.blogspot.com/','fil',30,'','2020-02-11 00:05:30'),(134,'CTE000002','English Education - Majorship','https://letqa.blogspot.com/','eng',30,'','2020-02-11 00:43:01'),(135,'CTE000002','Mathematics Education - Majorship','https://letqa.blogspot.com/','math',30,'','2020-02-11 01:04:49');
/*!40000 ALTER TABLE `reviewer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_results`
--

DROP TABLE IF EXISTS `test_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_results` (
  `tst_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `rvwr_id` int(11) NOT NULL,
  `qstn_id` int(11) NOT NULL,
  `answer` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`tst_id`),
  KEY `tests_to_user_fk` (`u_id`),
  KEY `tests_to_questionnaire_fk` (`qstn_id`),
  KEY `tests_to_reviewer_fk` (`rvwr_id`),
  CONSTRAINT `tests_to_questionnaire_fk` FOREIGN KEY (`qstn_id`) REFERENCES `questionnaire` (`qstn_id`) ON DELETE CASCADE,
  CONSTRAINT `tests_to_reviewer_fk` FOREIGN KEY (`rvwr_id`) REFERENCES `reviewer` (`rvwr_id`) ON DELETE CASCADE,
  CONSTRAINT `tests_to_user_fk` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='test results from reviewer';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_results`
--

LOCK TABLES `test_results` WRITE;
/*!40000 ALTER TABLE `test_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `u_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `given_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `name_suffix` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passkey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_status` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '1',
  `created_at` datetime DEFAULT current_timestamp(),
  `seq` int(6) unsigned zerofill NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('CTE000001','Neil Francis','Bayna','','superadmin','admin@admin.admin','Super Admin','$2y$10$Aqzm41GKWiprd1D30sCsFuix/2AaYUmQbvN5Sp.CDbc30nI4yHeH2','1','2019-08-07 10:19:16',000001,'superadmin03012020004313'),('CTE000002','Hazel Mae','Monterubio','','hazel','otheruser@email.com','Admin','$2y$10$DFHONo76DcCDIPKfNTMCe.FMeo4PiyJ0YzSLzyH5vx0fUrbjk3Qo2','1','2019-09-06 14:36:53',000010,'hazel02112020205820'),('CTE000011','Maria Ligaya','Madoro','','maria','maria@email.com','Admin','$2y$10$DFHONo76DcCDIPKfNTMCe.FMeo4PiyJ0YzSLzyH5vx0fUrbjk3Qo2','1','2019-09-10 14:26:32',000011,'maria02262020120654'),('CTE000012','Testee','Testing','','tester','tester@email.com','User','$2y$10$DFHONo76DcCDIPKfNTMCe.FMeo4PiyJ0YzSLzyH5vx0fUrbjk3Qo2','1','2019-09-10 14:26:32',000012,'tester02112020222710');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-01  0:59:48
