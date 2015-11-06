ALTER TABLE `fn_logactivities`
  ADD CONSTRAINT `fk_log_userid` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_logactivities_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
