ALTER TABLE `fn_user_finao`
  ADD CONSTRAINT `fk_usrfinao_status` FOREIGN KEY (`finao_status`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrfinao_updatedby` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrfinao_user` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_ibfk_1` FOREIGN KEY (`finao_status`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_ibfk_2` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_ibfk_3` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
