ALTER TABLE `fn_users`
  ADD CONSTRAINT `fk_user_gender` FOREIGN KEY (`gender`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_type` FOREIGN KEY (`usertypeid`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_users_ibfk_1` FOREIGN KEY (`gender`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_users_ibfk_2` FOREIGN KEY (`usertypeid`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
