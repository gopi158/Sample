ALTER TABLE `fn_user_profile`
  ADD CONSTRAINT `fn_user_profile_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_profile_ibfk_2` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_usrprof_createdby` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_usrprof_updatedby` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
