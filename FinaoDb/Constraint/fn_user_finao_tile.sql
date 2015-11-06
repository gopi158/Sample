ALTER TABLE `fn_user_finao_tile`
  ADD CONSTRAINT `fk_usrtile_createdby` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrtile_finao` FOREIGN KEY (`finao_id`) REFERENCES `fn_user_finao` (`user_finao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrtile_updateby` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrtile_userid` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_tile_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_tile_ibfk_2` FOREIGN KEY (`finao_id`) REFERENCES `fn_user_finao` (`user_finao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_tile_ibfk_3` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_tile_ibfk_4` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
